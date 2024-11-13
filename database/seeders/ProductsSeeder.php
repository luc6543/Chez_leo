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
        // Path to the CSV file
        $csvPath = base_path('database/Menukaart.csv'); // Adjust path as necessary

        // Open the CSV file using SplFileObject
        $csv = new \SplFileObject($csvPath);
        $csv->setFlags(\SplFileObject::READ_CSV);
        $csv->setCsvControl(';', '"', "\\"); // Define CSV control characters

        // Read the header row
        $headers = $csv->fgetcsv();

        // Skip the first row (headers) and process the data rows
        while (!$csv->eof()) {
            $row = $csv->fgetcsv();

            // Skip empty rows or rows with different columns than the header
            if ($row === [null] || count($row) !== count($headers)) {
                continue;
            }

            // Map the row data to the headers
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
