<?php

namespace App\Http\Controllers;

use App\Models\QuestNpc;
use App\Models\World;
use Illuminate\Http\Request;
use App\Models\nonPlayableCharacter;

class NpcController extends Controller
{
    public function viewNpcs()
    {
        $npcs = nonPlayableCharacter::withCount('dialogues')->get(['id', 'name', 'status']);

        return response()->json([
            'npcs' => $npcs
        ]);
    }

    public function storeNPC(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        nonPlayableCharacter::create($validated);
        return response()->json([
            'message' => 'NPC created successfully',
        ]);
    }

    public function storeQuestNPC(Request $request, World $world){
        $validated = $request->validate([
            'name' => 'required',
            'world_id' => 'required'
        ]);
        if($request->quest_id){
            $validated['quest_id'] = $request->quest_id;
        }
        QuestNpc::create($validated);
        return response()->json([
            'message' => 'NPC created successfully',
        ]);
    }
}
