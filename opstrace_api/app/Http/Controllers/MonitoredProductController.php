<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Models\MonitoredProduct;
use Exception;
use Illuminate\Http\Request;

class MonitoredProductController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $monitoredProducts = MonitoredProduct::query()
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate();

            $this->successResponse($monitoredProducts, "Monitored products retrieved successfully");
        } catch (Exception $e) {
            $this->errorResponse("Failed to retrieve monitored products", 500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'marketplace' => ['required', 'string', 'max:100'],
                'product_url' => ['required', 'url']
            ]);

            $monitoredProduct = MonitoredProduct::create([
                'user_id' => $request->user()->id,
                'name'=> $validated['name'],
                'marketplace'=> $validated['marketplace'],
                'product_url'=> $validated['product_url'],
                'monitoring_status' => 'success'
            ]);

            return $this->createdResponse($monitoredProduct, "Monitored product stored successfully");
        } catch (Exception $e) {
            return $this->errorResponse("Failed to store monitored products", 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonitoredProduct $monitoredProduct)
    {
        try {
            abort_if(
                $monitoredProduct->user_id !== $request->user()->id,
                403
            );

            $validated = $request->validate([
                'name' => ['sometimes', 'string', 'max:255'],
                'marketplace' => ['sometimes', 'string', 'max:100'],
                'product_url' => ['sometimes', 'url']
            ]);

            $monitoredProduct->update($validated);

            return $this->updatedResponse($monitoredProduct, "Monitored product updated successfully");
        } catch (Exception $e) {
            return $this->errorResponse("Failed to update monitored product", 500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, MonitoredProduct $monitoredProduct)
    {
        try {
            abort_if(
                $monitoredProduct->user_id !== $request->user()->id,
                403
            );

            $monitoredProduct->delete();

            return $this->deletedResponse("Monitored product deleted successfully");
        } catch (Exception $e) {
            return $this->errorResponse("Failed to delete monitored product", 500, $e->getMessage());
        }
    }
}
