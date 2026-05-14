<?php

namespace App\Livewire\Staff\Owner;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('staff.owner.layout')]
class Dashboard extends Component
{
    public function render()
    {
        return view('staff.owner.dashboard');
    }
}
