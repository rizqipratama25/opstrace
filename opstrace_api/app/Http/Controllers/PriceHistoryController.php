<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Models\Alert;
use App\Models\PriceHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class PriceHistoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $priceHistories = PriceHistory::query()
                ->with('monitoredProduct')
                ->latest()
                ->paginate();

            return $this->successResponse($priceHistories, "Price histories retrieved successfully");
        } catch (Exception $e) {
            return $this->errorResponse("Failed to retrieve price histories", 500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'monitored_product_id' => ['required', 'integer', 'exists:monitored_products,id'],
                'price' => ['required', 'integer'],
                'detected_at' => ['required', 'date'],
            ]);


            $priceHistory = PriceHistory::create([
                'monitored_product_id' => $validated['monitored_product_id'],
                'price' => $validated['price'],
                'detected_at' => $validated['detected_at'],
            ]);

            $oldPrice = $priceHistory->monitoredProduct->current_price;

            $newPrice = $priceHistory->price;
            $formattedPrice = number_format($newPrice, 0, ',', '.');
            $detectedAt = $priceHistory->detected_at;
            $formattedDetectedAt = $detectedAt->format('F j, Y, g:i A');

            if ($newPrice === $oldPrice) {
                $priceHistory->monitoredProduct->update([
                    'current_price' => $newPrice,
                    'last_checked_at' => $detectedAt
                ]);

                return $this->createdResponse($priceHistory, "Price history stored successfully. No price change detected.");
            }


            $message = "";
            $productInfo = "📦 Product: {$priceHistory->monitoredProduct->name}\n💰 Current Price: Rp {$formattedPrice}\n🕒 Last checked: {$formattedDetectedAt}";

            $alertType = "price_monitored";

            if (is_null($oldPrice)) {
                $message = "✅ Product is now being monitored.\n\n{$productInfo}";
            } else {
                if ($newPrice > $oldPrice) {
                    $message = "🔴 Price has increased!\n\n{$productInfo}";
                    $alertType = "price_up";
                } elseif ($newPrice < $oldPrice) {
                    $message = "🔴 Price has decreased!\n\n{$productInfo}";
                    $alertType = "price_down";
                }
            }

            $priceHistory->monitoredProduct->update([
                'current_price' => $newPrice,
                'last_checked_at' => $detectedAt
            ]);

            $alert = Alert::create([
                        "monitored_product_id" => $priceHistory->monitoredProduct->id,
                        "type" => $alertType,
                        "previous_price" => $oldPrice ?? 0,
                        "current_price" => $newPrice,
                        "message" => $message,
                        "is_sent" => false
                    ]);

            if ($priceHistory->monitoredProduct->user->telegram_id) {
                Telegram::bot('mybot')->sendMessage([
                    "chat_id" => $priceHistory->monitoredProduct->user->telegram_id,
                    "text" => $message
                ]);

                $alert->update([
                    "is_sent" => true
                ]);
            }

            return $this->createdResponse($priceHistory, "Price history stored successfully");
        } catch (Exception $e) {
            return $this->errorResponse("Failed to store price history", 500, $e->getMessage());
        }
    }
}
