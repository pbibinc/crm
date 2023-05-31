<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserProfilerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserProfile::create([
            'id' => 1,
            'firstname' => 'Pascal',
            'lastname' => 'Burke',
            'american_surname' => 'Burke',
            'id_num' => 'ID001',
            'position_id' => 1,
            'is_active' => 1,
            'department_id' => 1,
            'user_id' => 1
        ]);
    }
}
