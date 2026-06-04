<?php

namespace App\Livewire\Staff\Owner\AdminsManagement;

use App\Livewire\Forms\AdminForm;
use App\Services\Update\AdminService as UpdateAdminService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Update extends Component
{
    public string $adminId;
    public AdminForm $adminForm;

    public array $originalData = [];

    public function mount(
        string $adminId
    )
    {
        $this->adminId = $adminId;
        $rawData = app(\App\Services\Read\AdminService::class)->getAdminById($this->adminId);

        $this->adminForm->admin_id = $this->adminId;
        $this->adminForm->admin_name = $rawData['admin_name'];
        $this->adminForm->admin_number = $rawData['admin_number'];
        $this->adminForm->admin_role = $rawData['admin_role'];

        $this->originalData = $this->adminForm->all();
    }

    public function update(UpdateAdminService $adminService)
    {
        $currentData = $this->adminForm->all();

        if ($currentData == $this->originalData) {
            session()->flash('info', 'Tidak ada perubahan data yang dilakukan.');
            return $this->redirectRoute('owner.admins-management.index');    
        }

        $this->adminForm->validate();

        unset($currentData['password']);
        $adminService->updateAdmin($this->adminId, $currentData);

        session()->flash('success', 'Admin berhasil diperbarui!');
        return $this->redirectRoute('owner.admins-management.index');
    }

    public function render()
    {
        return view('staff.owner.admins-management.update');
    }
}