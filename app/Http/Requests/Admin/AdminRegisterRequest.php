<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
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
            'first_name'         => ['required'],
            'last_name'          => ['required'],
            'email'              => ['required', 'email', 'unique:admins,email'],
            'phone'              => ['required', 'unique:admins,phone', 'digits:11'],
            'national_id_number' => ['required', 'unique:admins,national_id_number', 'min:10', 'max:17'],
            'permanent_address'  => ['required'],
            'present_address'    => ['required'],
            'gender'             => ['required'],
            'password'           => ['required', 'confirmed'],
        ];
    }
}
