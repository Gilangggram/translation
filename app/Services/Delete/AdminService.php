<?php

namespace App\Services\Delete;

use App\Models\AdminAccount;

class AdminService {

    public function deleteAdmin(string $adminId) {
        $this->queryDeleteAdmin($adminId);
    }

    private function queryDeleteAdmin(string $adminId) {
        AdminAccount::where('admin_account_id', $adminId)
        ->firstOrFail()
        ->delete();
    }

}