<?php

namespace App\Livewire\Staff\Owner\StallsManagement;

use App\Livewire\Forms\StallForm;
use App\Models\Stall;
use App\Services\Read\StallService;
use App\Services\Update\StallService as UpdateStallService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Update extends Component
{
    public string $stallId;
    public StallForm $stallForm;

    public array $originalData      = [];

    public function mount(
        int $stallId
    )
    {
        $this->stallId          = $stallId;
        $rawData = $this->fetchData();

        $this->stallForm->stall_id = $this->stallId;
        $this->stallForm->stall_code    = $rawData['stall_code'];
        $this->stallForm->stall_name    = $rawData['stall_name'];
        $this->stallForm->owner_name    = $rawData['owner_name'];
        $this->stallForm->owner_number  = $rawData['owner_number'];

        $this->originalData = $this->stallForm->all();
    }

    public function fetchData() 
    {
        return app(StallService::class)->getStallById($this->stallId);
    }

    public function update(UpdateStallService $stallService)
    {
        $currentData = $this->stallForm->all();

        if ($currentData == $this->originalData) {
            session()->flash('info', 'Tidak ada perubahan data yang dilakukan.');
            return $this->redirectRoute('owner.stalls-management.index');    
        }

        $this->stallForm->validate();

        unset($currentData['password']);
        unset($currentData['stall_code']);
        $stallService->updateStall($this->stallId, $currentData);

        session()->flash('success', 'Stall berhasil diperbarui!');
        return $this->redirectRoute('owner.stalls-management.index');
    }

    public function render()
    {
        return view('staff.owner.stalls-management.update');
    }
}