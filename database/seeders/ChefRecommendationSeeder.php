<?php

namespace Database\Seeders;

use App\Models\Stall;
use Illuminate\Database\Seeder;

class ChefRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stall::all()->each(function($stall) {
            $stall->menus()->take(2)->get()->each(function($menu) {
                $menu->update(['is_chef_recommendation' => true]);
            });
        });
    }
}
