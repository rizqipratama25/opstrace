from playwright.sync_api import sync_playwright
import redis
import json
import requests
from datetime import datetime

# Connect to Redis
r = redis.Redis(host="127.0.0.1", port=6379, db=0, decode_responses=True)
print("Connected to Redis")

while True:

    # Pop a message from the queue
    _, payload = r.brpop('laravel-database-scraper_queue')

    # Decode the payload
    product = json.loads(payload)

    # Print the product details
    print(product)

    print(product["id"])
    print(product["name"])
    print(product["product_url"])

    with sync_playwright() as p:
        # Launch a new browser instance
        browser = p.chromium.launch(headless=False)
        
        # Create a new page
        page = browser.new_page()
        
        # Navigate to the product URL
        page.goto(product["product_url"])
        
        # Get the price of the product
        price_element = page.locator(".price")
        
        # Extract the price from the element
        price_text = price_element.inner_text()
        
        # Remove the currency symbol and decimal point
        clean_price = price_text.replace("Rp", "").replace(".", "")
        
        # Convert the cleaned price to an integer
        price = int(clean_price)
        
        # Declare the login data
        login_data = {
            "email": "admin@opstrace.com",
            "password": "admin123"
        }
        
        # Send a POST request to the login endpoint with the login data
        login_url = "http://127.0.0.1:8000/api/auth/login"
        login_response = requests.post(login_url, json=login_data)
        
        # Check if the login was successful
        if login_response.status_code == 200:
            # Extract the token from the response
            token = login_response.json()["data"]["token"]
            
            # Set the headers for the API requests
            headers = {
                "Authorization": f"Bearer {token}",
                "Accept": "application/json",
                "Content-Type": "application/json",
            }
            
            # Send a POST request to the monitoring-results endpoint with the product ID, price, and detected_at
            endpoint_url = "http://127.0.0.1:8000/api/monitoring-results"
            payload = {
                "monitored_product_id": product["id"],
                "price": price,
                "detected_at": datetime.now().isoformat()
            }
            response = requests.post(endpoint_url, json=payload, headers=headers)
            
            # Check if the request was successful
            print("Status: ", response.status_code)
            print("Response: ", response.json())
        else :
            # Handle login failure
            print("Login failed: ", login_response.text)
        
        
    
    