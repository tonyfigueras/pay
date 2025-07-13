<?php

namespace App\Http\Controllers;

use App\Models\Galaxy;
use App\Models\World;
use Illuminate\Http\Request;

class GalaxyController extends Controller
{
    public function viewGalaxies() {
        // Eager load the 'worlds' relationship (including those without worlds)
        $galaxies = Galaxy::with('worlds')->get();

        // Map through each galaxy and append the number of worlds and status
        $galaxiesWithWorlds = $galaxies->map(function($galaxy) {
            return [
                'id' => $galaxy->id,
                'name' => $galaxy->name,
                'worlds_count' => $galaxy->worlds->count(), // Count the number of worlds, returns 0 if none
                'under_construction' => $galaxy->under_construction ? 1 : 0,
            ];
        });

        return response()->json([
            'galaxies' => $galaxiesWithWorlds
        ]);
    }

    public function addGalaxy(Request $request){
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'under_construction' => 'required', // Remove the boolean rule here
        ]);

        // Convert the 'under_construction' string to a boolean and then to 0/1
        $validated['under_construction'] = filter_var($request->under_construction, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        // Create the galaxy with the validated data
        Galaxy::create($validated);

        return response()->json([
            'message' => "Galaxy created"
        ]);
    }

    public function viewGalaxy(Galaxy $galaxy) {
        // Fetch worlds that belong to the selected galaxy and eager load the quests
        $worlds = $galaxy->worlds()->with('sections')->get();

        // Map through each world and append the number of quests
        $worldsWithQuests = $worlds->map(function($world) {
            return [
                'id' => $world->id,
                'name' => $world->name,
                'quests_count' => $world->sections->count(), // Count the number of quests
                'order' => $world->order,
                'unlocked' => $world->unlocked,
            ];
        });

        return response()->json([
            'worlds' => $worldsWithQuests
        ]);
    }
}
