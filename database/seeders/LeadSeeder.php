<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Lead::create([
            'id' => 1,
            'company_name' => 'Do Not Delete',
            'tel_num' => '0000000000',
            'state_abbr' => 'CA',
            'class_code' => '0000',
            'website_originated' => 'https://www.google.com',
            'status' => 10000,
            'prime_lead' => 1,
        ]);

    }
}
