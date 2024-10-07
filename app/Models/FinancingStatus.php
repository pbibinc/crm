<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingStatus extends Model
{
    use HasFactory;
    protected $table = 'financing_status';
    protected $fillable = [
        'quotation_product_id',
        'selected_quote_id',
        'status',
    ];
    public $timestamps = false;

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quotation_product_id');
    }

    public function getProductFinancing()
    {
        $data = self::where('status', 'Request For Financing')->with('QuotationProduct')->get();
        return $data->isEmpty() ? [] : $data;
    }

    public function getPfaProcessing()
    {
        $data = self::where('status', 'Processing of PFA')->with('QuotationProduct')->get();
        return $data->isEmpty() ? [] : $data;
    }

    public function incompletePfa()
    {
        $data = self::where('status', 'Incomplete PFA')->with('QuotationProduct')->get();
        return $data->isEmpty() ? [] : $data;
    }

}