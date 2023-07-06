<?php

namespace Database\Seeders;

use App\Models\RecreationalFacilities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecreationalFacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities =[
            ['name' => 'hospitals'],
            ['name' => 'churches'],
            ['name' => 'school'],
            ['name' => 'playground']
        ];
        foreach ($facilities as $facility) {
            RecreationalFacilities::create($facility);
        }
    }
}