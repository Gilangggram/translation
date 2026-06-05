<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class StallForm extends Form
{
    public ?string $stall_id = null;
    
    public $owner_number = '';
    public $password = '';
    public $stall_code = '';
    public $stall_name = '';
    public $owner_name = '';

    public function rules(): array
    {
        $rules = [
            'stall_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
        ];

        if ($this->stall_id) {
            $rules['owner_number'] = [
                'required',
                'string',
                'digits_between:8,15',
                'unique:stall_accounts,phone_number,' . $this->stall_id . ',stall_id'
            ];
        } else {
            $rules['password'] = 'required|string|min:6';
            $rules['owner_number'] = 'required|string|digits_between:8,15|unique:stall_accounts,phone_number';
            $rules['stall_code']   = 'required|string|max:7|unique:stalls,stall_code';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'owner_number.required' => 'Nomor telepon wajib diisi.',
            'owner_number.digits_between' => 'Nomor telepon harus antara 8 - 15 digit.',
            'owner_number.unique' => 'Nomor telepon sudah digunakan.',
            'stall_code.required' => 'Kode stall wajib diisi.',
            'stall_code.max' => 'Kode stall maksimal 7 karakter.',
            'stall_code.unique' => 'Kode stall sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'stall_name.required' => 'Nama lapak wajib diisi.',
            'stall_name.max' => 'Nama lapak maksimal 255 karakter.',
            'owner_name.required' => 'Nama pemilik wajib diisi.',
            'owner_name.max' => 'Nama pemilik maksimal 255 karakter.',
        ];
    }
}
