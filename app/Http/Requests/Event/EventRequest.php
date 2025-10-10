<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'date' => ['required', 'string'],
            'icon' => ['nullable'],
            'banner' => ['nullable'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable','string', 'max:255']
        ];
    }
}
