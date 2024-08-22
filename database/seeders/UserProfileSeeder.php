<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserProfile::create([
            'id' => 1,
            'firstname' => 'Maechael',
            'lastname' => 'Elchico',
            'american_name' => 'Blippi',
            'id_num' => 001,
            'position_id' => 1,
            'is_active' => 1,
            'department_id' => 1,
            'user_id' => 1,
            'media_id' => 1
        ]);
    }
}