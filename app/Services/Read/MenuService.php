<?php

namespace App\Services\Read;

use App\Models\Menu;

class MenuService {

    public function getMenusCount(): int {  
        return $this->queryMenusCount();
    }

    public function getActiveMenusByStall(int $stallId): array {
        return $this->queryActiveMenusByStall($stallId);
    }

    public function getActiveMenusByStallAndSearch(int $stallId, string $search): array {
        return $this->queryActiveMenusByStallAndSearch($stallId, $search);
    }

    public function getArchiveMenusByStall(int $stallId): array {
        return $this->queryArchiveMenusByStall($stallId);
    }

    public function getArchiveMenusByStallAndSearch(int $stallId, string $search): array {
        return $this->queryArchiveMenusByStallAndSearch($stallId, $search);
    }

    private function queryMenusCount(): int {
        return Menu::query()
            ->count();
    }

    private function queryActiveMenusByStall(int $stallId): array
    {
        return Menu::query()
            ->where('stall_id', $stallId)
            ->select(
                'menu_id',
                'image_path as menu_image',
                'name as menu_name',
                'description as menu_desc',
                'price as menu_price',
                'is_chef_favorite as is_menu_chef_favorite',
                'is_available as is_menu_available',
            )
            ->get()
            ->toArray();
    }

    private function queryActiveMenusByStallAndSearch(int $stallId, string $search): array
    {
        return Menu::query()
            ->where('stall_id', $stallId)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%");
            })
            ->select(
                'menu_id',
                'image_path as menu_image',
                'name as menu_name',
                'description as menu_desc',
                'price as menu_price',
                'is_chef_favorite as is_menu_chef_favorite',
                'is_available as is_menu_available',
            )
            ->get()
            ->toArray();
    }

    private function queryArchiveMenusByStall(int $stallId): array
    {
        return Menu::onlyTrashed()
            ->where('stall_id', $stallId)
            ->select(
                'menu_id',
                'image_path as menu_image',
                'name as menu_name',
                'description as menu_desc',
                'price as menu_price',
                'is_chef_favorite as is_menu_chef_favorite',
                'is_available as is_menu_available',
            )
            ->get()
            ->toArray();
    }

    private function queryArchiveMenusByStallAndSearch(int $stallId, string $search): array
    {
        return Menu::onlyTrashed()
            ->where('stall_id', $stallId)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%");
            })
            ->select(
                'menu_id',
                'image_path as menu_image',
                'name as menu_name',
                'description as menu_desc',
                'price as menu_price',
                'is_chef_favorite as is_menu_chef_favorite',
                'is_available as is_menu_available',
            )
            ->get()
            ->toArray();
    }

}