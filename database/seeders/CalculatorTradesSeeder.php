<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalculatorTrades;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CalculatorTradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalculatorTrades::truncate();

        $data = File::get("database/data/calculator_trades.json");
        $trades = json_decode($data);

        foreach ($trades as $trade) {
            CalculatorTrades::create([
                "id" => $trade->id,
                "tradename" => $trade->tradename,
                "gl_iso" => $trade->gl_iso,
                "description" => $trade->description,
            ]);
        }
    }
}