<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Section;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function createTest(Section $section, Request $request){

        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:500'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'questions' => ['nullable', 'array'],
            'questions.*.name' => ['required_with:variations', 'string'],
            'questions.*.answers' => ['required_with:variations', 'array'],
            'variations.*.answers.*.answer' => ['required_with:questions', 'string'],
        ]);

        Test::create($validated);

        if (isset($validated['questions'])) {
            foreach ($validated['questions'] as $question) {
                // Create the variation for the product
                $question = Question::create([
                    'section_id' => $section->id,
                    'question' => $question['question'],
                ]);

                // Create the variation values
                foreach ($validated['answers'] as $answer) {
                    Answer::create([
                        'question_id' => $question->id,
                        'value' => $answer['answer'],
                        'correct' => $answer['is_correct'],
                    ]);
                }
            }
        }
    }


}
