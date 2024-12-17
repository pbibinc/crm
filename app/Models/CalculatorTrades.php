<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalculatorTrades extends Model
{
    use HasFactory;

    protected $table = 'calculator_trades_table';
    protected $guarded = [];

    public $timestamps = false;

    public function getTradeNames($array_id) {
        if (is_array($array_id)) {
            $data = $this->whereIn('id', $array_id)->pluck('tradename')->toArray();
            return $data;
        }
        return [];
    }

}