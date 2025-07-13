<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Section;
use App\Models\World;
use Illuminate\Http\Request;

class QuestsController extends Controller
{
    public function viewQuests()
    {
        $quests = Quest::all();
        return response()->json($quests);
    }

    public function viewQuest(Section $section, Quest $quest, World $world){
        $quest->load(['steps']);
        return response()->json([
            "quest" => $quest,
            "questnpcs" => $world->questnpcs,
            "items" => $world->items,
            "minigames" => $world->minigames,
            "tests" => $world->tests,
        ]);
    }

    public function createQuest(World $world, Section $section, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'npc_triggerer' => 'required',
        ]);

        $validated['world_id'] = $world->id;
        $validated['section_id'] = $section->id;

        // Find the latest section in the world
        $latestQuest = Quest::where('section_id', $section->id)->orderBy('order', 'desc')->first();

        if ($latestQuest) {
            // Increment the order based on the latest section's order
            $validated['order'] = $latestQuest->order + 1;
        } else {
            // If no sections exist, this is the first section, so assign order 1
            $validated['order'] = 1;
        }

        // Create the quest
        Quest::create($validated);

        return response()->json([
            'Message' => 'Quest created!'
        ]);
    }

    public function createStep(Quest $quest, Request $request){
        /*
        'quest_id',
        'target_questnpc', // in case the user needs to go to someone to tick this step
        'order',
        */
        $validated = request()->validate([
            'order',
        ]);
    }

    public function createEvent(){

    }
}
