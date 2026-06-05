<?php

namespace App\Livewire\Staff\Owner\StallsManagement;

use App\Services\Read\MenuService;
use App\Services\Read\StallService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('staff.owner.layout')]
class Detail extends Component
{
    public string $search = '';
    public string $selectedNav = 'active';
    public array $selectedRow = [];

    public int $stallId;
    public array $stallData = [];

    public array $columns = [
        ['key' => 'menu_name', 'label' => 'Nama'],
        ['key' => 'menu_desc', 'label' => 'Deskripsi'],
        ['key' => 'menu_price', 'label' => 'Harga'],
        ['key' => 'is_menu_available', 'label' => 'Ketersediaan Menu'],
        ['key' => 'action', 'label' => 'Aksi'],
    ];

    public function mount(
        int $stallId
    ): void {
        $this->stallId = $stallId;
        $this->stallData = $this->fetchStallData();
    }

    public function fetchStallData(): array {
        
        return app(StallService::class)->getStallById($this->stallId);
    }

    public function fetchMenuData() {
        if ($this->selectedNav === 'active') {
            return $this->search
                ? app(MenuService::class)->getActiveMenusByStallAndSearch($this->stallId, $this->search)
                : app(MenuService::class)->getActiveMenusByStall($this->stallId);
        } else {
            return $this->search
                ? app(MenuService::class)->getArchiveMenusByStallAndSearch($this->stallId, $this->search)
                : app(MenuService::class)->getArchiveMenusByStall($this->stallId);
        }
    }

    public function getStallStatusClasses(bool $status): string
    {
        return $status
            ? 'bg-[#B6DDA5] text-[#246009]'
            : 'bg-[#F9B1B1] text-[#AD1614]';
    }

    public function getMenuStatusClasses(bool $status): string
    {
        return $status
            ? 'bg-[#B6DDA5] text-[#246009]'
            : 'bg-[#F9B1B1] text-[#AD1614]';
    }

    public function render()
    {
        return view('staff.owner.stalls-management.detail');
    }
}
