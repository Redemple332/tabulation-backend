<?php

namespace App\Http\Requests\Score;

use Illuminate\Foundation\Http\FormRequest;

class ScoreRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'judge_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'scores' => ['required', 'array'],
            'scores.*.candidate_id' => ['required', 'exists:candidates,id'],
            'scores.*.score' => ['required', 'numeric'],
            'scores.*.description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
