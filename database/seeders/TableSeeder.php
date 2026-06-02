<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            Table::firstOrCreate(
                ['table_number' => (string)$i],
                ['is_available' => true]
            );
        }
    }
}
