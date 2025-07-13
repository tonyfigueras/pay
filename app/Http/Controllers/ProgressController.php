<?php

namespace App\Http\Controllers;

use App\Events\QuestCompleted;
use App\Events\SectionCompleted;
use App\Events\StepCompleted;
use App\Events\WorldCompleted;
use App\Models\Quest;
use App\Models\Section;
use App\Models\Step;
use App\Models\User;
use App\Models\World;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function completeStep(World $world, Section $section, Quest $quest, Step $step)
    {
        $userId = auth()->id(); // Get the authenticated user's ID
        $user = User::findOrFail($userId); // Find the user

        // Fetch related world, section, and quest from the step
        $stepQuest = $step->quest;
        $stepSection = $stepQuest->section;
        $stepWorld = $stepSection->world;

        // Ensure the step belongs to the correct world, section, and quest
        if ($stepWorld->id !== $world->id || $stepSection->id !== $section->id || $stepQuest->id !== $quest->id) {
            return response()->json(['error' => 'Step does not belong to this world, section, or quest'], 400);
        }

        // Ensure the world is marked as active in `world_user`
        $isWorldActive = $user->worlds()->where('world_user.world_id', $world->id)->where('world_user.is_active', true)->exists();
        if (!$isWorldActive) {
            // Mark the world as active if it's not already active
            $user->worlds()->attach($world->id, [
                'is_active' => true,
                'completed' => false,
                'completed_at' => null
            ]);
        }

        // Ensure the section is marked as active in `section_user`
        $isSectionActive = $user->sections()->where('section_user.section_id', $section->id)->where('section_user.is_active', true)->exists();
        if (!$isSectionActive) {
            // Mark the section as active if it's not already active
            $user->sections()->attach($section->id, [
                'is_active' => true,
                'completed' => false,
                'world_id' => $world->id,
                'completed_at' => null
            ]);
        }

        // Ensure the quest is marked as active in `quest_user`
        $isQuestActive = $user->quests()->where('quest_user.quest_id', $quest->id)->where('quest_user.is_active', true)->exists();
        if (!$isQuestActive) {
            // Mark the quest as active if it's not already active
            $user->quests()->attach($quest->id, [
                'is_active' => true,
                'completed' => false,
                'world_id' => $world->id,
                'completed_at' => null
            ]);
        }

        // Check if the step is already completed
        $isStepCompleted = $user->steps()->where('step_user.step_id', $step->id)->where('step_user.completed', true)->exists();
        if ($isStepCompleted) {
            return response()->json(['error' => 'This step has already been completed'], 403); // Error if the step is already completed
        }

        // Check if the step is the first one in the quest and no steps are active
        $firstStep = Step::where('quest_id', $quest->id)->orderBy('order', 'asc')->first();
        $existingActiveStep = $user->steps()->where('steps.quest_id', $quest->id)->where('step_user.is_active', true)->exists();

        // If this is the first step and no steps are active, activate it
        if ($step->id === $firstStep->id && !$existingActiveStep) {
            $user->steps()->attach($step->id, [
                'is_active' => true,
                'completed' => false,
                'world_id' => $world->id,
                'quest_id' => $quest->id,
                'completed_at' => null
            ]);
        }

        // Ensure the step is active for the user before marking it as complete
        $isStepActive = $user->steps()->where('step_user.step_id', $step->id)->where('step_user.is_active', true)->exists();
        if (!$isStepActive) {
            return response()->json(['error' => 'This step is not active for the user'], 403); // Error if not active
        }

        // Mark the current step as completed in `step_user`
        $user->steps()->updateExistingPivot($step->id, [
            'completed' => true,
            'completed_at' => now(),
            'is_active' => false,
            'world_id' => $world->id,  // Include world_id in the pivot table update
            'quest_id' => $quest->id   // Include quest_id in the pivot table update
        ]);

        // Check if there is a next step in the quest
        $nextStep = Step::where('quest_id', $quest->id)
            ->where('order', '>', $step->order)
            ->first();

        if ($nextStep) {
            // If the next step doesn't exist in the pivot, we attach it
            $nextStepExists = $user->steps()->where('step_user.step_id', $nextStep->id)->exists();
            if (!$nextStepExists) {
                $user->steps()->attach($nextStep->id, [
                    'is_active' => true,
                    'completed' => false,
                    'world_id' => $world->id,
                    'quest_id' => $quest->id,
                    'completed_at' => null
                ]);
            } else {
                // If it exists, just update it as active
                $user->steps()->updateExistingPivot($nextStep->id, [
                    'is_active' => true,
                    'completed' => false
                ]);
            }
        } else {
            // If it's the last step, complete the quest in `quest_user`
            $this->completeQuest($userId, $quest->id);

            // Check if this is the last quest in the section
            $nextQuest = Quest::where('section_id', $section->id)
                ->where('order', '>', $quest->order)
                ->first();

            if ($nextQuest) {
                // If the next quest exists, activate it
                $nextQuestExists = $user->quests()->where('quest_user.quest_id', $nextQuest->id)->exists();
                if (!$nextQuestExists) {
                    $user->quests()->attach($nextQuest->id, [
                        'is_active' => true,
                        'completed' => false,
                        'world_id' => $world->id,
                        'completed_at' => null
                    ]);
                }
            } else {
                // If this is the last quest, complete the section and world
                $this->completeSection($userId, $section->id, $world->id);
            }
        }

        // Broadcast step completion
        // broadcast(new StepCompleted($user->id, $step->id, $nextStep ? $nextStep : null));
        StepCompleted::dispatch($user->id, $step->id, $nextStep ? $nextStep : null);
        return response()->json(['message' => 'Step completed successfully']);
    }

    public function completeQuest($userId, $questId)
    {
        $user = User::findOrFail($userId);
        $quest = Quest::findOrFail($questId);

        // Ensure we include the `world_id` when marking the quest as completed
        $worldId = $quest->section->world_id;  // Fetch the world_id from the quest's section

        // Check if the quest already exists in the pivot table for the user
        $existingQuest = $user->quests()->where('quest_user.quest_id', $questId)->exists();

        if ($existingQuest) {
            // If the quest exists, update the pivot table
            $user->quests()->updateExistingPivot($questId, [
                'completed' => true,
                'completed_at' => now(),
                'is_active' => false,
                'world_id' => $worldId // Include world_id in the pivot table update
            ]);
        } else {
            // If the quest doesn't exist, attach a new row
            $user->quests()->attach($questId, [
                'completed' => true,
                'completed_at' => now(),
                'is_active' => false,
                'world_id' => $worldId // Include world_id in the pivot table
            ]);
        }

        // Check if there is another quest in the section
        $nextQuest = Quest::where('section_id', $quest->section_id)
            ->where('order', '>', $quest->order)
            ->first();

        if ($nextQuest) {
            // Mark the next quest as active in `quest_user`
            $nextQuestExists = $user->quests()->where('quest_user.quest_id', $nextQuest->id)->exists();
            if (!$nextQuestExists) {
                // Only attach if the next quest doesn't already exist
                $user->quests()->attach($nextQuest->id, [
                    'is_active' => true,
                    'completed' => false,
                    'world_id' => $worldId // Include world_id when attaching the next quest
                ]);

                // Now, find the first step of the new quest and mark it as active
                $firstStep = Step::where('quest_id', $nextQuest->id)->orderBy('order', 'asc')->first();
                if ($firstStep) {
                    // Mark the first step of the next quest as active
                    $user->steps()->attach($firstStep->id, [
                        'is_active' => true,
                        'completed' => false,
                        'world_id' => $worldId,
                        'quest_id' => $nextQuest->id,
                        'completed_at' => null // Ensure completed_at is null
                    ]);
                }
                // broadcast(new QuestCompleted($user->id, $nextQuest->id, $firstStep->id ?? null));
                event(new QuestCompleted($user->id, $nextQuest->id, $firstStep->id ?? null));
            }
        } else {
            // If it's the last quest, complete the section and pass the world_id
            $this->completeSection($userId, $quest->section_id, $worldId);
        }
    }

    public function completeSection($userId, $sectionId, $worldId = null)
    {
        $user = User::findOrFail($userId);
        $section = Section::findOrFail($sectionId);

        // If world_id is not passed, fetch it from the section
        if (!$worldId) {
            $worldId = $section->world_id;
        }

        // Mark the section as completed in `section_user`
        $user->sections()->updateExistingPivot($sectionId, [
            'completed' => true,
            'completed_at' => now(),
            'is_active' => false,
            'world_id' => $worldId // Include world_id in the pivot table update
        ]);

        // Check if there is another section in the world
        $nextSection = Section::where('world_id', $section->world_id)
            ->where('order', '>', $section->order)
            ->first();

        if ($nextSection) {
            // Mark the next section as active in `section_user`
            $user->sections()->attach($nextSection->id, [
                'is_active' => true,
                'completed' => false,
                'world_id' => $worldId // Include world_id when attaching the next section
            ]);
            //broadcast(new SectionCompleted($userId, $sectionId, $nextSection->id, $worldId)); // Include next section ID
            event(new SectionCompleted($userId, $sectionId, $nextSection->id, $worldId)); // Include next section ID
        } else {
            // If it's the last section, complete the world
            $this->completeWorld($userId, $section->world_id);
        }
    }

    public function completeWorld($userId, $worldId)
    {
        $user = User::findOrFail($userId);
        $world = World::findOrFail($worldId);

        // Check if the world is already active in `world_user`
        $existingWorld = $user->worlds()->where('world_user.world_id', $worldId)->exists();

        if ($existingWorld) {
            // If the world exists, update the pivot table to mark it as completed
            $user->worlds()->updateExistingPivot($worldId, [
                'completed' => true,
                'completed_at' => now(),
                'is_active' => false
            ]);
        } else {
            // If no entry exists, create a new one and mark it as active
            $user->worlds()->attach($worldId, [
                'is_active' => true,
                'completed' => false,
                'completed_at' => null
            ]);
        }

        // Check if there is a next world (based on the order)
        $nextWorld = World::where('order', '>', $world->order)->first();

        if ($nextWorld) {
            // If there's a next world, mark it as active
            $nextWorldExists = $user->worlds()->where('world_user.world_id', $nextWorld->id)->exists();
            if (!$nextWorldExists) {
                $user->worlds()->attach($nextWorld->id, [
                    'is_active' => true,
                    'completed' => false,
                    'completed_at' => null
                ]);
                // Broadcast that the current world is completed and there's a next world
                // broadcast(new WorldCompleted($userId, $worldId, $nextWorld->id));
                event(new WorldCompleted($userId, $worldId, $nextWorld->id));
            } else {
                // Broadcast that the world is completed and there is no next world
                // broadcast(new WorldCompleted($userId, $worldId, null));
                event(new WorldCompleted($userId, $worldId, null));
            }
        }
    }

}
