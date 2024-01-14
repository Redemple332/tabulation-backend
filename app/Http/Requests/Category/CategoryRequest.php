<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => ['required','string','max:50'],
            'percentage' => ['required','numeric'],
            'candidate_limit' => ['required','numeric'],
            'min_score' => ['required','numeric'],
            'max_score' => ['required','numeric'],
            'order' => ['required','numeric'],
            'status' => ['required','boolean'],
            'isCurrent' => ['required','boolean'],
            'description' => ['nullable','string', 'max:255']
        ];
    }
}
