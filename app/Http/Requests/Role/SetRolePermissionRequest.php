<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class SetRolePermissionRequest extends FormRequest
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
            'role_id' => ['required', 'uuid'],
            'permission_ids' => ['required','array','min:3']
        ];
    }
}
