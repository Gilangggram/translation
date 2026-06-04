<?php

namespace App\Services\Restore;

use App\Models\AdminAccount;

class AdminService {

    public function restoreAdmin(string $adminId) {
        $this->queryRestoreAdmin($adminId);
    }

    private function queryRestoreAdmin(string $adminId) {
        AdminAccount::onlyTrashed()
        ->where('admin_account_id', $adminId)
        ->firstOrFail()
        ->restore();
    }
}