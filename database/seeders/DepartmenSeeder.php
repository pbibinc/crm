<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['id' => 1, 'name' => 'IT Department'],
            ['id' => 2, 'name' => 'CSR Department'],
            ['id' => 3, 'name' => 'Admin Department'],
            ['id' => 4, 'name' => 'Accounting Department'],
            ['id' => 5, 'name' => 'Sales Department'],
            ['id' => 6, 'name' => 'Wholesale Department'],
            ['id' => 7, 'name' => 'IT Department'],
            ['id' => 8, 'name' => 'Quotation Department'],

        ];
        Department::insert($data);
    }
}
