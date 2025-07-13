<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\World;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function createSection(Request $request, World $world) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $validated['world_id'] = $world->id;

        // Find the latest section in the world
        $latestSection = Section::where('world_id', $world->id)->orderBy('order', 'desc')->first();

        if ($latestSection) {
            // Increment the order based on the latest section's order
            $validated['order'] = $latestSection->order + 1;
        } else {
            // If no sections exist, this is the first section, so assign order 1
            $validated['order'] = 1;
        }

        // Create the section
        Section::create($validated);

        return response()->json([
            'Message' => 'Section created!'
        ]);
    }

    public function viewSection(Section $section){
        $section->load(['quests']);
        return response()->json([
            'section' => $section
        ]);
    }

}
