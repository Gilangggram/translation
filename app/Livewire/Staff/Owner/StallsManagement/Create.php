<?php

namespace App\Livewire\Staff\Owner\StallsManagement;

use App\Livewire\Forms\StallForm;
use App\Services\Read\StallService as ReadStallService;
use App\Services\Create\StallService as CreateStallService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Create extends Component
{
    public StallForm $stallForm;
    public string $generatedStallCode = '';

    public function mount(): void
    {
        $this->generatedStallCode = $this->generateStallCode();
    }

    public function generateStallCode(): string
    {

        $lastCode = app(ReadStallService::class)->getStallCode();

        if (!$lastCode) return 'ST-A001';

        $letter = $lastCode[3]; 
        $number = (int) substr($lastCode, 4);

        if ($number < 999) {
            return 'ST-' . $letter . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        }

        if ($letter === 'Z') {
            throw new \Exception('Kode stall sudah habis (ST-Z999).');
        }

        return 'ST-' . chr(ord($letter) + 1) . '001';
    }

    public function save(CreateStallService $stallService) 
    {
        $this->stallForm->stall_code = $this->generatedStallCode;
        
        $this->stallForm->validate();

        $data = $this->stallForm->all();

        $data['password'] = bcrypt($data['password']);

        $stallService->addStall($data);

        session()->flash('success', 'Stall berhasil dibuat!');
        return $this->redirectRoute('owner.stalls-management.index');
    }
    
    public function render()
    {
        return view('staff.owner.stalls-management.create');
    }

    
}
