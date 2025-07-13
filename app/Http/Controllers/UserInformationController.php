<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserInformationController extends Controller
{
    public function getInformation(){
        $user = auth('sanctum')->user();
        return response()->json([
            'info' => $user->currentlocations
        ]);
    }

    public function updateInformation(Request $request){
        $user = auth('sanctum')->user();

        $validatedData = $request->validate([
            'galaxy_id' => 'required|integer',
            'world_id' => 'required|integer',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'z' => 'required|numeric',
        ]);

        // Check if current location exists, or create it if not
        $currentLocation = $user->currentlocations()->firstOrNew([]);
        $currentLocation->fill($validatedData);
        $currentLocation->save();

        return response()->json([
            'message' => 'Data updated successfully'
        ], 200);
    }

    public function getUserCustomization(Request $request){
        $user = auth('sanctum')->user();
        return response()->json([
           'customizations' => $user->userCustomizations,
        ]);
    }

    public function updateUserCustomization(Request $request){
        $user = auth('sanctum')->user();

        $validatedData = $request->validate([
            'skin_color' => 'required|string',
            'hair_color' => 'required|string',
            'eyes_color' => 'required|string'
        ]);

        // Check if current customization exists, or create it if not
        $currentCustomization = $user->userCustomizations()->firstOrNew([]);
        $currentCustomization->fill($validatedData);
        $currentCustomization->save();

        return response()->json([
            'message' => 'Data updated successfully'
        ], 200);
    }

    public function updateAvatar(Request $request)
    {
        $user = auth('sanctum')->user();

        $validatedData = $request->validate([
            'items' => 'required|array', // Array of product IDs to activate
        ]);

        $productIds = $validatedData['items'];

        // Retrieve the products to ensure valid IDs and group them by type
        $products = Product::whereIn('id', $productIds)->get()->groupBy('type');

        foreach ($products as $type => $productsByType) {
            // Ensure only one product ID is activated per category
            $productIdToActivate = $productsByType->pluck('id')->first();

            if (!$productIdToActivate) {
                continue; // Skip if no product to activate
            }

            // Deactivate currently active products of this type for the user
            $user->products()
                ->wherePivot('is_active', true)
                ->whereIn('product_id', Product::where('type', $type)->pluck('id'))
                ->update(['is_active' => false]);

            // Activate the provided product for this type
            $user->products()->syncWithoutDetaching([
                $productIdToActivate => ['is_active' => true],
            ]);
        }

        return response()->json([
            'message' => 'Products updated successfully',
        ]);
    }

    public function getActiveItems()
    {
        $user = auth('sanctum')->user();

        // Fetch only active products for the user
        $activeProducts = $user->products()
            ->wherePivot('is_active', true)
            ->get(); // Directly fetch only active products

        // Format the response grouped by type
        $formattedProducts = $activeProducts->groupBy('type')->map(function ($products) {
            return $products->first(); // Each category only has one active item
        });

        return response()->json([
            'active_items' => $formattedProducts->values(), // Return as array for easier front-end parsing
        ]);
    }

}
