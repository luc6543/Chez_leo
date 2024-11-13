<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PHPUnit\Runner\Baseline\Reader;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('database/Menukaart.csv');

        $csv = new \SplFileObject($csvPath);
        $csv->setFlags(\SplFileObject::READ_CSV);
        $csv->setCsvControl(';', '"', "\\");

        $headers = $csv->fgetcsv();

        while (!$csv->eof()) {
            $row = $csv->fgetcsv();

            if ($row === [null] || count($row) !== count($headers)) {
                continue;
            }

            $rowData = array_combine($headers, $row);

//            dd($rowData["\u{FEFF}Categorie"]);

            // Insert each row into the `menukaart` table
            DB::table('products')->insert([
                'category' => $rowData["\u{FEFF}Categorie"],
                'dish_name' => $rowData['Gerecht'],
                'description' => $rowData['Beschrijving'],
                'price' => floatval(str_replace(',', '.', $rowData['Prijs'])),
            ]);
        }
    }
}
