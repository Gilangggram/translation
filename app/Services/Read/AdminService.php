<?php

namespace App\Services\Read;

use App\Models\AdminAccount;

class AdminService {

    public function getActiveAdmins(): array {
        return $this->queryActiveAdmins();
    }
    
    public function getActiveAdminsBySearch(string $search): array {
        return $this->queryActiveAdminsBySearch($search);
    }

    public function getArchiveAdmins(): array {
        return $this->queryArchiveAdmins();
    }

    public function getArchiveAdminsBySearch(string $search): array {
        return $this->queryArchiveAdminsBySearch($search);
    }

    public function getAdminById(string $adminId): array {
        return AdminAccount::withTrashed()
            ->where('admin_account_id', $adminId)
            ->select(
                'admin_account_id as admin_id',
                'name as admin_name',
                'phone_number as admin_number',
                'role as admin_role',
            )
            ->firstOrFail()
            ->toArray();
    }
    
    private function queryActiveAdmins(): array {
        return AdminAccount::query()
            ->select(
                'admin_account_id as admin_id',
                'name as admin_name',
                'phone_number as admin_number',
                'role as admin_role',
            )
            ->get()
            ->toArray();
    }
    
    private function queryActiveAdminsBySearch(string $search): array {
        return AdminAccount::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('phone_number', 'like', "%{$search}%")
            ->orWhere('role', 'like', "%{$search}%")
            ->select(
                'admin_account_id as admin_id',
                'name as admin_name',
                'phone_number as admin_number',
                'role as admin_role',
            )
            ->get()
            ->toArray();
    }

    private function queryArchiveAdmins(): array {
        return AdminAccount::onlyTrashed()
            ->select(
                'admin_account_id as admin_id',
                'name as admin_name',
                'phone_number as admin_number',
                'role as admin_role',
            )
            ->get()
            ->toArray();
    }

    private function queryArchiveAdminsBySearch(string $search): array {
        return AdminAccount::onlyTrashed()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('phone_number', 'like', "%{$search}%")
            ->orWhere('role', 'like', "%{$search}%")
            ->select(
                'admin_account_id as admin_id',
                'name as admin_name',
                'phone_number as admin_number',
                'role as admin_role',
            )
            ->get()
            ->toArray();
    }

}