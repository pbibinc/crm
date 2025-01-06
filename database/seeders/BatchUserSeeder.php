<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Events\PublishingStubs;
use Illuminate\Support\Facades\Hash;

class BatchUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $filePath = public_path('backend/assets/user_batch_file.xlsx');

        $file = fopen($filePath, 'r');
        $data = [];

        while(($row = fgetcsv($file)) !== false){
            $data[] = [
                'id' => $row[0],
                'name' => $row[1],
                'username' => $row[2],
                'password' => Hash::make($row[3]),
                'email' => $row[4],
                'role_id' => $row[5],
                'is_admin' => $row[6],
            ];
        }
        fclose($file);
        User::insert($data);
    }
}
