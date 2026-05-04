<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_number'  => 'required|string|digits_between:8,15',
            'password'      => 'required|string|min:6',
        ];
    }

    public function messages():array {
        return [
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.digits_between' => 'Nomor telepon harus antara 8 - 15 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ];
    }
}
