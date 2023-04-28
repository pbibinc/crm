<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        RolePermissionSeeder::create([
           'id' => 1,
            'permission_id' => 1,
            'role_id' => 5,
        ]);
    }
}
