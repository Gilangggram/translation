<?php

namespace App\Livewire\Staff\Owner\AdminsManagement;

use App\Livewire\Forms\AdminForm;
use App\Services\Create\AdminService as CreateAdminService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Create extends Component
{
    public AdminForm $adminForm;
    
    public function save(CreateAdminService $adminService) {
        $this->adminForm->validate();

        $data = $this->adminForm->all();

        $data['password'] = bcrypt($data['password']);

        $adminService->addNewAdmin($data);

        session()->flash('success', 'Admin berhasil dibuat!');
        return $this->redirectRoute('owner.admins-management.index');
    }

    public function render()
    {
        return view('staff.owner.admins-management.create');
    }
}