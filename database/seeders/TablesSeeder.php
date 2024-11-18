<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Table::updateOrCreate([
            'chairs' => 10,
            'table_number' => 1,
        ]);
        Table::updateOrCreate([
            'chairs' => 2,
            'table_number' => 2,
        ]);
        Table::updateOrCreate([
            'chairs' => 4,
            'table_number' => 3,
        ]);
        Table::updateOrCreate([
            'chairs' => 4,
            'table_number' => 4,
        ]);
        Table::updateOrCreate([
            'chairs' => 6,
            'table_number' => 5,
        ]);
    }
}
