<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchUserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to your CSV file
        $filePath = public_path('backend/assets/user_profile_batch_file.xlsx');

        // Read the file contents
        $file = fopen($filePath, 'r');
        $data = [];

        while(($row = fgetcsv($file)) !== false){
             // Convert birthdate to `YYYY-MM-DD` format
            $birthdate = null; // Default to null if no valid date provided
            if (!empty($row[6])) {
              try {
                $birthdate = Carbon::createFromFormat('m/d/Y', $row[6])->format('Y-m-d');
               } catch (\Exception $e) {
                 // Handle invalid date format if needed
                $birthdate = null;
               }
            }

            $data[] = [
                'american_name' => $row[0],
                'firstname' => $row[1],
                'lastname' => $row[2],
                'id_num' => $row[3],
                'skype_profile' => $row[4],
                'streams_number' => $row[5],
                'brithday' => $row[6],
                'position_id' => $row[7],
                'department_id' => $row[8],
            ];
        }
        fclose($file);
        UserProfile::insert($data);


    }
}