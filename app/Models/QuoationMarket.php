<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoationMarket extends Model
{
    use HasFactory;

    protected $table = 'quotation_market_table';
    protected $fillable = ['name'];
    public $timestamps = false;


    public function products()
    {
        return $this->hasMany(MarketProduct::class, 'market_id', 'id');
    }

    public static function getMarketByProduct($product)
    {
        $marketIds = MarketProduct::where('name', $product)->pluck('market_id')->toArray();

        return self::whereIn('id', $marketIds)->get();
    }
}
