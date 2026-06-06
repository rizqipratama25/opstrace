<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Models\PriceHistory;
use Exception;
use Illuminate\Http\Request;

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

            $priceHistory->monitoredProduct->update([
                'current_price' => $validated['price'],
                'last_checked_at' => $validated['detected_at']
            ]);

            return $this->createdResponse($priceHistory, "Price history stored successfully");
        } catch (Exception $e) {
            return $this->errorResponse("Failed to store price history", 500, $e->getMessage());
        }
    }
}
