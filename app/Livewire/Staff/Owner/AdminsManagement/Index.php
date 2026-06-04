<?php

namespace App\Livewire\Staff\Owner\AdminsManagement;

use App\Services\Read\AdminService;
use Livewire\Component;
use App\Services\Delete\AdminService as DeleteAdminService;
use App\Services\Restore\AdminService as RestoreAdminService;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Index extends Component
{
    public string $search = '';
    public string $selectedNav = 'active';

    public array $columns = [
        ['key' => 'admin_name', 'label' => 'Nama Admin',],
        ['key' => 'admin_number', 'label' => 'No. HP Admin'],
        ['key' => 'admin_role', 'label' => 'Role'],
        ['key' => 'action', 'label' => 'Aksi'],
    ];

    public function fetchData()
    {
        if ($this->selectedNav === 'active') {
            return $this->search
                ? app(AdminService::class)->getActiveAdminsBySearch($this->search)
                : app(AdminService::class)->getActiveAdmins();
        } else {
            return $this->search
                ? app(AdminService::class)->getArchiveAdminsBySearch($this->search)
                : app(AdminService::class)->getArchiveAdmins();
        }
    }

    public function delete(string $admin_id, DeleteAdminService $deleteAdminService)
    {
        $deleteAdminService->deleteAdmin($admin_id);

        session()->flash('success', 'Admin berhasil diarsipkan!');
    }

    public function restore(string $admin_id, RestoreAdminService $restoreAdminService)
    {
        $restoreAdminService->restoreAdmin($admin_id);

        session()->flash('success', 'Admin berhasil dikembalikan!');
    }

    public function render()
    {
        return view('staff.owner.admins-management.index');
    }
}