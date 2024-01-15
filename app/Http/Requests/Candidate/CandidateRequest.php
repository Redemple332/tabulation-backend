<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
            'first_name' => ['required','string','max:50'],
            'last_name' => ['required','string','max:50'],
            'no' => ['required','numeric'],
            'gender' => ['required','string','max:50'],
            'age' => ['required','numeric'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'contact' => ['nullable','string'],
            'address' => ['nullable','string'],
            'status' => ['required','boolean'],
            'description' => ['nullable','string', 'max:255']
        ];
    }
}
