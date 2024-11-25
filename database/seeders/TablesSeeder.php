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
        // Remove all existing tables
        Table::truncate();

        // Define the tables based on the number of chairs and the count of tables given by the client
        $tables = [
            ['chairs' => 2, 'count' => 6],
            ['chairs' => 4, 'count' => 4],
            ['chairs' => 5, 'count' => 2],
            ['chairs' => 6, 'count' => 2],
        ];

        // Initialize the table number
        $tableNumber = 1;

        // Create the tables
        foreach ($tables as $table) {
            for ($i = 0; $i < $table['count']; $i++) {
                Table::updateOrCreate([
                    'chairs' => $table['chairs'],
                    'table_number' => $tableNumber++,
                ]);
            }
        }
    }
}
