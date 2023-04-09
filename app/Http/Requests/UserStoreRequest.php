<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'role' => [
                'required',
                'in:admin,customer',
                'unique:table,column,except,idColumn',
            ],
            'phone' => ['nullable', 'unique:users,phone', 'max:255', 'string'],
            'roles' => 'array',
        ];
    }
}
