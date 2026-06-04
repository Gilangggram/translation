<?php

namespace App\Services\Create;

use App\Models\AdminAccount;

class AdminService {

    public function addNewAdmin(array $adminData) {
        $this->queryNewAdmin($adminData);
    }

    private function queryNewAdmin(array $adminData) {
        AdminAccount::create([
            'name' => $adminData['admin_name'],
            'phone_number' => $adminData['admin_number'],
            'password' => $adminData['password'],
            'role' => $adminData['admin_role'],
        ]);
    }
}