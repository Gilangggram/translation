<?php

namespace App\Services\Read;

use App\Models\Stall;

class StallService {

    public function getStallsCount(): int {  
        return $this->queryStallsCount();
    }

    public function getActiveStalls(): array {
        return $this->queryActiveStalls();
    }

    public function getActiveStallsBySearch(string $search): array {
        return $this->queryActiveStallsBySearch($search);
    }

    public function getArchiveStalls(): array {
        return $this->queryArchiveStalls();
    }
    
    public function getArchiveStallsBySearch(string $search): array {
        return $this->queryArchiveStallsBySearch($search);
    }

    public function getStallById(int $stallId): array {
        return $this->queryStallById($stallId);
    }

    public function getStallCode(): ?string {
        return $this->queryStallCode();
    }

    private function queryStallsCount(): int {
        return Stall::count();
    }

    private function queryActiveStalls(): array {

        return Stall::query()
            ->join('stall_accounts', 'stalls.stall_id', '=', 'stall_accounts.stall_id')
            ->leftJoin('menus', 'stalls.stall_id', '=', 'menus.stall_id')
            ->select(
                'stall_accounts.stall_account_id as stall_account_id',
                'stalls.stall_id as stall_id',
                'stalls.stall_code as stall_code',
                'stalls.name as stall_name',
                'stalls.owner_name as owner_name',
                'stalls.is_open as is_open',
                'stall_accounts.phone_number as owner_number',
            )
            ->selectRaw('COUNT(menus.menu_id) as menu_count')
            ->groupBy(
                'stall_accounts.stall_account_id',
                'stalls.stall_id',
                'stalls.stall_code',
                'stalls.name',
                'stalls.owner_name',
                'stalls.is_open',
                'stall_accounts.phone_number',
            )
            ->get()
            ->toArray();
    }

    private function queryActiveStallsBySearch(string $search): array {

        return Stall::query()
            ->join('stall_accounts', 'stalls.stall_id', '=', 'stall_accounts.stall_id')
            ->leftJoin('menus', 'stalls.stall_id', '=', 'menus.stall_id')
            ->where('stalls.name', 'like', "%{$search}%")
            ->orWhere('stalls.owner_name', 'like', "%{$search}%")
            ->orWhere('stall_accounts.phone_number', 'like', "%{$search}%")
            ->select(
                'stall_accounts.stall_account_id as stall_account_id',
                'stalls.stall_id as stall_id',
                'stalls.stall_code as stall_code',
                'stalls.name as stall_name',
                'stalls.owner_name as owner_name',
                'stalls.is_open as is_open',
                'stall_accounts.phone_number as owner_number',
            )
            ->selectRaw('COUNT(menus.menu_id) as menu_count')
            ->groupBy(
                'stall_accounts.stall_account_id',
                'stalls.stall_id',
                'stalls.stall_code',
                'stalls.name',
                'stalls.owner_name',
                'stalls.is_open',
                'stall_accounts.phone_number',
            )
            ->get()
            ->toArray();
    }

    private function queryArchiveStalls(): array {
        return Stall::onlyTrashed()
            ->join('stall_accounts', 'stalls.stall_id', '=', 'stall_accounts.stall_id')
            ->leftJoin('menus', 'stalls.stall_id', '=', 'menus.stall_id')
            ->select(
                'stall_accounts.stall_account_id as stall_account_id',
                'stalls.stall_id as stall_id',
                'stalls.stall_code as stall_code',
                'stalls.name as stall_name',
                'stalls.owner_name as owner_name',
                'stalls.is_open as is_open',
                'stalls.deleted_at as deleted_at',
                'stall_accounts.phone_number as owner_number',
            )
            ->selectRaw('COUNT(menus.menu_id) as menu_count')
            ->groupBy(
                'stall_accounts.stall_account_id',
                'stalls.stall_id',
                'stalls.stall_code',
                'stalls.name',
                'stalls.owner_name',
                'stalls.is_open',
                'stalls.deleted_at',
                'stall_accounts.phone_number',
            )
            ->get()
            ->toArray();
    }
    
    private function queryArchiveStallsBySearch(string $search): array {
        return Stall::onlyTrashed()
            ->join('stall_accounts', 'stalls.stall_id', '=', 'stall_accounts.stall_id')
            ->leftJoin('menus', 'stalls.stall_id', '=', 'menus.stall_id')
            ->where('stalls.name', 'like', "%{$search}%")
            ->orWhere('stalls.owner_name', 'like', "%{$search}%")
            ->orWhere('stall_accounts.phone_number', 'like', "%{$search}%")
            ->select(
                'stall_accounts.stall_account_id as stall_account_id',
                'stalls.stall_id as stall_id',
                'stalls.stall_code as stall_code',
                'stalls.name as stall_name',
                'stalls.owner_name as owner_name',
                'stalls.is_open as is_open',
                'stalls.deleted_at as deleted_at',
                'stall_accounts.phone_number as owner_number',
            )
            ->selectRaw('COUNT(menus.menu_id) as menu_count')
            ->groupBy(
                'stall_accounts.stall_account_id',
                'stalls.stall_id',
                'stalls.stall_code',
                'stalls.name',
                'stalls.owner_name',
                'stalls.is_open',
                'stalls.deleted_at',
                'stall_accounts.phone_number',
            )
            ->get()
            ->toArray();
    }

    private function queryStallById(int $stallId): array
    {
        $stall = Stall::withTrashed()
            ->join('stall_accounts', 'stalls.stall_id', '=', 'stall_accounts.stall_id')
            ->where('stalls.stall_id', $stallId)
            ->select(
                'stall_accounts.stall_account_id as stall_account_id',
                'stalls.stall_id as stall_id',
                'stalls.stall_code as stall_code',
                'stalls.name as stall_name',
                'stalls.owner_name as owner_name',
                'stalls.is_open as is_open',
                'stalls.created_at as created_at',
                'stall_accounts.phone_number as owner_number',
            )
            ->firstOrFail();

        return array_merge($stall->toArray(), [
            'created_at' => $stall->created_at->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    private function queryStallCode(): ?string {
        return Stall::query()
            ->orderByDesc('stall_id')
            ->value('stall_code');
    }
}