<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'id' => 1,
            'role_id' => 5,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'username' => 'admin',
            'is_admin' => 1
        ]);
    }
}
