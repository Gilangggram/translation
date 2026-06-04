<?php

namespace App\Livewire\Staff\Owner\StallsManagement;

use App\Services\Read\StallService;
use Livewire\Component;
use App\Services\Delete\StallService as DeleteStallService;
use App\Services\Restore\StallService as RestoreStallService;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Index extends Component
{
    public string $search = '';
    public string $selectedNav = 'active';

    public array $columns = [
        ['key' => 'stall_name',   'label' => 'Nama Stall'],
        ['key' => 'owner_name',   'label' => 'Nama Pemilik'],
        ['key' => 'owner_number', 'label' => 'No. HP Pemilik'],
        ['key' => 'is_open',      'label' => 'Status'],
        ['key' => 'menu_count',   'label' => 'Menu'],
        ['key' => 'action',       'label' => 'Aksi'],
    ];

    public function fetchData()
    {
        if ($this->selectedNav === 'active') {
            return $this->search
                ? app(StallService::class)->getActiveStallsBySearch($this->search)
                : app(StallService::class)->getActiveStalls();
        } else {
            return $this->search
                ? app(StallService::class)->getArchiveStallsBySearch($this->search)
                : app(StallService::class)->getArchiveStalls();
        }
    }

    public function delete(string $stall_id, DeleteStallService $deleteStallService)
    {
        $deleteStallService->deleteStall($stall_id);
        session()->flash('success', 'Stall berhasil dihapus!');
    }

    public function restore(string $stall_id, RestoreStallService $restoreStallService)
    {
        $restoreStallService->restoreStall($stall_id);
        session()->flash('success', 'Stall berhasil dikembalikan!');
    }

    public function getStallStatusClasses(bool $status): string
    {
        return $status
            ? 'bg-[#B6DDA5] text-[#246009]'
            : 'bg-[#F9B1B1] text-[#AD1614]';
    }

    public function render()
    {
        return view('staff.owner.stalls-management.index');
    }
}
