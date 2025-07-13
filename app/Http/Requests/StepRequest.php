<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'minigame' => $this->input('minigame') === '' ? null : $this->input('minigame'),
            'test_id' => $this->input('test_id') === '' ? null : $this->input('test_id'),
            'item' => $this->input('item') === '' ? null : $this->input('item'),
            'target_npc' => $this->input('target_npc') === '' ? null : $this->input('target_npc'),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'instructions' => 'nullable|max:256', // Optional field, limited to 256 characters
            'activity' => 'required|in:bring_to,talk_to,test,mini_game', // Must be one of the valid activities
            'quest_npc' => 'nullable|integer',
            'target_npc' => 'nullable|integer',  // Nullable but required conditionally
            'item' => 'nullable|integer',
            'minigame' => 'nullable|exists:minigames,id',  // Assuming minigames is a table
            'test_id' => 'nullable|integer', // Nullable but required conditionally
        ];
    }

    /**
     * Add custom validation logic after the standard validation.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $activity = $this->input('activity');

            // Validation based on activity type
            if ($activity === 'talk_to') {
                // For 'talk_to', target_npc must be filled
                if (!$this->filled('target_npc')) {
                    $validator->errors()->add('target_npc', 'The target_npc field is required when activity is set to talk_to.');
                }
            }

            if ($activity === 'bring_to') {
                // For 'bring_to', both target_npc and item must be filled
                if (!$this->filled('target_npc')) {
                    $validator->errors()->add('target_npc', 'The target_npc field is required when activity is set to bring_to.');
                }
                if (!$this->filled('item')) {
                    $validator->errors()->add('item', 'The item field is required when activity is set to bring_to.');
                }
            }

            if ($activity === 'test') {
                // For 'test', test_id is required
                if (!$this->filled('test_id')) {
                    $validator->errors()->add('test_id', 'The test_id field is required when activity is set to test.');
                }
            }

            if ($activity === 'minigame') {
                // For 'test', test_id is required
                if (!$this->filled('minigame')) {
                    $validator->errors()->add('minigame', 'The test_id field is required when activity is set to minigame.');
                }
            }

        });
    }
}
