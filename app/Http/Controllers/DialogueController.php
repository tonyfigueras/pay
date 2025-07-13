<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\nonPlayableCharacter;
use Illuminate\Http\Request;
use App\Models\Dialogue;
use App\Models\Chat;

class DialogueController extends Controller
{
    public function viewDialogues()
    {
        $dialogues = Dialogue::with('nonplayablecharacter:name') // Load related NPC data with only name and id
        ->get()
            ->map(function ($dialogue) {
                return [
                    'dialogue_name' => $dialogue->dialogue_name,
                    'npc_name' => $dialogue->nonPlayableCharacter ? $dialogue->nonPlayableCharacter->name : null,
                    'test' => $dialogue->has_test ? 'Yes' : 'No', // Indicate if the dialogue has a test
                ];
            });

        return response()->json($dialogues);
    }

    public function getNpcInfo(NonPlayableCharacter $character){
        return response()->json([
            'name' => $character->name,
        ]);
    }

    public function npcDialogues(nonPlayableCharacter $nonPlayableCharacter)
    {
        // Retrieve all dialogues for the given NPC
        $dialogues = $nonPlayableCharacter->dialogues()->get();

        // Map over the dialogues and include the chat count within each dialogue
        $dialoguesWithChatCount = $dialogues->map(function ($dialogue) {
            // Add a chat_count property to each dialogue instance
            $dialogue->chat_count = $dialogue->chats()->count();
            return $dialogue;
        });

        return response()->json([
            'npc_dialogues' => $dialoguesWithChatCount,
        ]);
    }

    public function addDialogue(nonPlayableCharacter $character)
    {
        // Validate the incoming request data
        $validated = request()->validate([
            'dialogue_name' => 'required',
            'non_playable_character_id' => 'required|exists:non_playable_characters,id', // Ensure NPC exists
            'previous_dialogue_id' => 'nullable|numeric|exists:dialogues,id' // Ensure previous dialogue ID is valid
        ]);

        // Check if a dialogue already references the given previous dialogue for this NPC
        if (isset($validated['previous_dialogue_id'])) {
            $existingDialogue = Dialogue::where('non_playable_character_id', $validated['non_playable_character_id'])
                ->where('previous_dialogue_id', $validated['previous_dialogue_id'])
                ->first();

            if ($existingDialogue) {
                // Return an error response if such a dialogue already exists
                return response()->json([
                    'message' => "A dialogue already references this previous dialogue for the specified NPC."
                ], 400);
            }
        }

        // Create a new dialogue since no conflicting dialogue was found
        Dialogue::create($validated);

        return response()->json([
            'message' => "Dialogue created successfully."
        ], 200);
    }

    public function addChat(Dialogue $dialogue)
    {
        // Validate the incoming request data
        $validated = request()->validate([
            'content' => 'required'
        ]);

        // Check for the latest chat order in the given dialogue
        $latestChat = $dialogue->chats()->orderBy('order', 'desc')->first();

        if ($latestChat) {
            // If a chat exists, set the new order to the latest chat's order + 1
            $validated['order'] = $latestChat->order + 1;
        } else {
            // If no chat exists, set the order to 1
            $validated['order'] = 1;
        }

        // Associate the chat with the dialogue
        $validated['dialogue_id'] = $dialogue->id;

        // Create the new chat
        Chat::create($validated);

        return response()->json([
            'message' => "Chat added successfully."
        ], 200);
    }

    public function viewDialogueDetails(Dialogue $dialogue){
        return response()->json([
            'dialogue' => $dialogue,
            'chats' => $dialogue->chats()->get()
        ]);
    }

    public function addAnswer(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'chat_id',
            'answer' => 'required',
            'correct' => 'required',
        ]);

        Answer::create($validated);
    }

    private function checkIfAnswersAreCorrect(Request $request, Chat $chat, Answer $answer)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.id' => 'required|exists:answers,id',
        ]);

        // Extract the answer IDs from the request
        $answerIds = array_column($validated['answers'], 'id');

        // Fetch the answers from the database
        $answers = Answer::whereIn('id', $answerIds)->get();

        // Count how many answers are marked as correct
        $correctAnswersCount = $answers->where('correct', true)->count();

        // Log or use the count of correct answers as needed
        $totalAnswersinQuestion = count($chat->answers);

        if ($correctAnswersCount == $totalAnswersinQuestion) {
            return response()->json([
                'message' => $chat->success_message,
            ]);
        }

        if ($answers->count() > $correctAnswersCount) {
            return response()->json([
                'message' => 'You got ' . $correctAnswersCount . ' out of ' . $totalAnswersinQuestion . ' answers correct.',
                'alt_message' => $chat->meh_message,
            ]);
        }

        if ($correctAnswersCount == 0) {
            return response()->json([
                'message' => "Pfff... seems like you did not pay attention at all. Try again!",
                'alt_message' => $chat->failure_message,
            ]);
        }

        return response()->json([
            'correctAnswersCount' => $correctAnswersCount,
            'totalAnswersinQuestion' => $totalAnswersinQuestion,
        ]);

    }

    public function changeChatOrder(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:chats,id',
            'order.*.position' => 'required|integer',
        ]);

        // Loop through the order array and update each chat's position
        foreach ($validated['order'] as $item) {
            Chat::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['message' => 'Chat order updated successfully.']);
    }
}
