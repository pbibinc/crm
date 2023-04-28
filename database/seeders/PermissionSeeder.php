<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
                [
                    'id' => 1,
                    'name' => 'edit_role'
                ],
                [
                    'id' => 2,
                    'name' => 'create_permission'
                ],
        ]);
    }
}
