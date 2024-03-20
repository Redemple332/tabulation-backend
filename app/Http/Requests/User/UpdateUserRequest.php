<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name' => ['nullable','string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255', 'min:2'],
            'contact' => ['required', 'string', 'max:255', 'min:2'],
            'address' => ['required', 'string', 'max:255', 'min:2'],
            'judge_no' => ['numeric'],
            'email' => ['required', 'email', 'string', 'max:255', Rule::unique('users')->ignore($this->route('user'))],
            'password' => ['required', 'min:6', 'max:16', 'string', 'confirmed'],
            'is_active' => ['boolean'],
            'category_id' => ['required', 'exists:categories,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'description' => ['nullable']
        ];
    }

    public function attributes(): array
    {
        return [
            'role_id' => 'role',
            'department_id' => 'department',
        ];
    }
}
