<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AdminForm extends Form
{
    public ?string $admin_id = null;

    public $admin_number = '';
    public $admin_name = '';
    public $password = '';
    public $admin_role = '';
    
    public function rules(): array
    {
        $rules = [
            'admin_name' => 'required|string|max:255',
            'admin_role' => 'required|in:owner,cashier',
        ];

        if ($this->admin_id) {
            $rules['admin_number'] = [
                'required',
                'string',
                'digits_between:8,15',
                'unique:admin_accounts,phone_number,' . $this->admin_id . ',admin_account_id'
            ];
        } else {
            $rules['password'] = 'required|string|min:6';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'admin_number.required' => 'Nomor telepon wajib diisi.',
            'admin_number.digits_between' => 'Nomor telepon harus antara 8 - 15 digit.',
            'admin_number.unique' => 'Nomor telepon sudah digunakan.',
            'admin_name.required' => 'Nama admin wajib diisi.',
            'admin_name.max' => 'Nama admin maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'admin_role.required' => 'Role wajib diisi.',
            'admin_role.in' => 'Role harus berupa owner atau cashier.',
        ];
    }
}
