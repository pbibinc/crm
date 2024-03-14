<?php

namespace App\Models;

use Carbon\Carbon;
use DGvai\BladeAdminLTE\Components\Card;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingAgreement extends Model
{
    use HasFactory;

    protected $table = 'financing_agreement';

    protected $fillable = [
        'quote_comparison_id',
        'financing_company_id',
        'is_auto_pay',
        'media_id',
    ];

    public function QuoteComparison()
    {
        return $this->belongsTo(QuoteComparison::class, 'quote_comparison_id');
    }
    public function media()
    {
        return $this->belongsTo(Metadata::class, 'media_id');
    }

    public function PaymentOption()
    {
        return $this->hasOne(PaymentOption::class, 'financing_agreement_id');
    }

    public function getNewFinancingAgreement()
    {
        $today = Carbon::now()->format('Y-m-d h:i:s');
        $thirtyDaysAgo = Carbon::now()->subDays(30)->format('Y-m-d h:i:s');

        $data = self::whereDate('created_at', '>=', $thirtyDaysAgo)->whereDate('created_at', '<=', $today)->get();

        return $data->isEmpty() ? []: $data;
    }
}