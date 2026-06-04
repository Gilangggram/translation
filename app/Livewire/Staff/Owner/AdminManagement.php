<?php

namespace App\Livewire\Staff\Owner;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class AdminManagement extends Component
{
    public function render()
    {
        return view('staff.owner.admin-management');
    }
}

