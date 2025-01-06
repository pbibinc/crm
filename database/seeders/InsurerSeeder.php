<?php

namespace Database\Seeders;

use App\Models\Insurer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Path to your CSV file
        $filePath = public_path('backend/assets/insurance_companies.csv'); // Ensure the file is placed here

        // Read the file contents
        $file = fopen($filePath, 'r');
        $data = [];

        // Skip the header row
        $header = fgetcsv($file);

        // Process each row
        while (($row = fgetcsv($file)) !== false) {
            $data[] = [
                'name' => $row[1],          // Second column is the name
                'naic_number' => $row[2],  // Third column is the NAIC number
            ];
        }
        fclose($file);
        Insurer::insert($data);
    }
}