<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

                'name' => 'required|string|max:255',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:6',

        ];
    }

    public function messages()
    {
        return [
        'name.required' => 'Name is required.',
        'phone.required' => 'Phone number is required.',
        'phone.unique' => 'Phone number has already been taken.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
    ];
    }
}
