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
        $data = [
            ['id' => 1, 'name' => 'edit_role'],
            ['id' => 2, 'name' => 'create_permission'],
            ['id' => 3, 'name' => 'edit_permission'],
            ['id' => 4, 'name' => 'delete_permission'],
            ['id' => 5, 'name' => 'create_department'],
            ['id' => 6, 'name' => 'edit_department'],
            ['id' => 7, 'name' => 'delete_department'],
            ['id' => 8, 'name' => 'create_position'],
            ['id' => 9, 'name' => 'edit_position'],
            ['id' => 10, 'name' => 'delete_position'],
            ['id' => 11, 'name' => 'create_role'],
            ['id' => 12, 'name' => 'delete_role'],
            ['id' => 13, 'name' => 'assign_role'],
            ['id' => 14, 'name' => 'delete_user'],
            ['id' => 15, 'name' => 'create_user-profile'],
            ['id' => 16, 'name' => 'edit_user-profile'],
            ['id' => 17, 'name' => 'delete_user-profile'],
            ['id' => 21, 'name' => 'view_position'],
            ['id' => 22, 'name' => 'view_department'],
            ['id' => 23, 'name' => 'view_user-profile'],
            ['id' => 24, 'name' => 'view_admin_nav'],
            ['id' => 26, 'name' => 'view_leads_funnel'],
            ['id' => 27, 'name' => 'view_import_leads'],
            ['id' => 28, 'name' => 'view_permission'],
            ['id' => 29, 'name' => 'view_leads_nav'],
            ['id' => 30, 'name' => 'view_attendance'],

        ];
        Permission::insert($data);
    }
}