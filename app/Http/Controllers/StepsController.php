<?php

namespace App\Http\Controllers;

use App\Http\Requests\StepRequest;
use App\Models\Quest;
use App\Models\Section;
use App\Models\Step;
use App\Models\World;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StepsController extends Controller
{
    public function storeStep(Section $section, Quest $quest, World $world, StepRequest $request)
    {
        // The validation is automatically handled by StepRequest
        $validated = $request->validated();  // Get the validated data

        // Add the quest ID to the validated data
        $validated['quest_id'] = $quest->id;

        // Convert empty string values to null before storing in the database
        $validated['test_id'] = $validated['test_id'] === '' ? null : $validated['test_id'];
        $validated['minigame'] = $validated['minigame'] === '' ? null : $validated['minigame'];

        // Ensure target_npc is properly handled
        if ($validated['activity'] === 'talk_to' && $validated['target_npc'] === '') {
            $validated['target_npc'] = null;
        }

        // Retrieve the latest step within this quest and determine the order
        $latestStep = Step::where('quest_id', $quest->id)->orderBy('order', 'desc')->first();

        if ($latestStep) {
            // Increment the order based on the latest step's order
            $validated['order'] = $latestStep->order + 1;
        } else {
            // If no steps exist, assign order as 1
            $validated['order'] = 1;
        }

        // Create the step with the validated data
        Step::create($validated);

        return response()->json([
            'message' => 'Step created successfully',
        ]);
    }




    public function markQuestCompleted(Quest $quest){

    }

    public function markSectionCompleted(Section $section){

    }

    public function addStep(Quest $quest){

    }
}
