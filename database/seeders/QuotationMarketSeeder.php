<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotationMarketSeeder extends Seeder
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
            ['name' => 'Contractors Shield (CS)'],
            ['name' => 'Safebuilt Insurance Services (Sis)'],
            ['name' => "Builders & Tradesmen's Insurance Services (Btis)"],
            ['name' => 'Hiscox'],
            ['name' => 'Sole Proprietor'],
            ['name' => 'Houston Casualty Company (HCC)'],
            ['name' => 'Tapco'],
            ['name' => 'UTICA First'],
            ['name' => 'State Fund First'],
            ['name' => 'ATLAS'],
            ['name' => 'NATGEN'],
            ['name' => 'Next Insurance'],
            ['name' => 'Texas Mutual'],
            ['name' => 'Coterie'],
            ['name' => 'CNA'],
            ['name' => 'Guard'],
            ['name' => 'Thimble'],
            ['name' => 'Old Republic'],
            ['name' => 'London Underwriters'],
            ['name' => 'Pathpoint'],
            ['name' => 'Slice'],
            ['name' => 'RPS'],
            ['name' => 'Novus Underwriter'],
            ['name' => 'The Hartford'],
            ['name' => 'Hourly'],
            ['name' => 'AMTRUST'],
            ['name' => 'Commodore Ins'],
            ['name' => 'One80'],
            ['name' => 'CCI Surety, Inc.'],
            ['name' => 'Suppression Pro'],
            ['name' => 'NORTHEAST COVERAGES, INC.'],
            ['name' => 'Bryant Surety Bonds, Inc.'],
            ['name' => 'CRC Group'],
            ['name' => 'Brown and Riding'],
        ];
        DB::table('quotation_market_table')->insert($data);
    }
}
