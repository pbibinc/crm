<?php

namespace Database\Seeders;

use App\Models\FinancingCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinanceCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Premco Financial Corporation'],
            ['name' => 'Agile Premium Finance'],
            ['name' => 'Columbia Pacific Finance'],
            ['name' => 'Professional Premium Acceptance Corporation'],
            ['name' => 'BTIS DirectPay'],
            ['name' => 'Best Choice'],
            ['name' => 'First Solutions Finance Company'],
            ['name' => 'Bank Direct Capital one'],
            ['name' => 'Hiscox'],
            ['name' => 'GOTOpremiumfinance'],
            ['name' => 'First Insurance Funding'],
        ];

        FinancingCompany::insert($data);

    }
}