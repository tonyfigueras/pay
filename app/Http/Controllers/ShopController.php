<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{

    public function viewProducts(){
        $products = Product::all();
        return response()->json([
            'products' => $products
        ]);
    }

    public function getUserProducts(){
        $user = auth('sanctum')->user();

        return response()->json([
           'products' => $user->products,
        ]);
    }

    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "type" => "required",
            "price" => "required",
        ]);
        Product::create($validated);
        return response()->json([
            "message" => "Item added successfully."
        ], 200);
    }

    public function buyItem(Product $product)
    {
        $user = auth()->user();
        if ($user->wallet < $product->price) {
            return response()->json([
                "message" => "Insufficient balance."
            ]);
        }
        DB::beginTransaction();
        try {
            if (!$user->products()->where('product_id', $product->id)->exists()) {
                $user->products()->attach($product->id);
                $user->wallet = $user->wallet - $product->price;
                $user->save();
                DB::commit();
                return response()->json([
                    "message" => "Item purchased successfully.",
                    "product" => $product->id
                ], 200);
            }
            return response()->json([
                "message" => "You already own the item."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "An error occurred while purchasing the item.",
                "error" => $e->getMessage() // Optional: Include the error message for debugging
            ], 500);
        }
    }

    public function checkBalance(User $user)
    {
        return response()->json([
            "balance" => auth()->user()->wallet
        ], 200);
    }

    public function giveBalance(Request $request, User $user)
    {
        $validated = $request->validate([
            "wallet" => "required|numeric|min:0"
        ]);
        $user['wallet'] = $user->wallet + $validated['wallet'];
        $user->save();
        return response()->json([
            "message" => "Gave balance successfully."
        ], 200);
    }
}
