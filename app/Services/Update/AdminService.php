<?php

namespace App\Services\Update;

use App\Models\AdminAccount;

class AdminService {

    public function updateAdmin(string $adminId, array $adminData) {
        $this->queryUpdateAdmin($adminId, $adminData);
    }

    private function queryUpdateAdmin(string $adminId, array $adminData) {
        AdminAccount::withTrashed()
            ->where('admin_account_id', $adminId)
            ->firstOrFail()
            ->update([
                'name' => $adminData['admin_name'],
                'phone_number' => $adminData['admin_number'],
                'role' => $adminData['admin_role'],
            ]);
    }

}