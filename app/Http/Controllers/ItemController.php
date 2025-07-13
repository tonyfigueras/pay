<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\World;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function createItem(World $world, Request $request){
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $validated['world_id'] = $world->id;

        Item::create($validated);

        return response()->json([
           'message' => 'Item created successfully'
        ]);
    }
}
