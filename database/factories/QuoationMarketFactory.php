<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuotaionMarket>
 */
class QuoationMarketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
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
    }
}
