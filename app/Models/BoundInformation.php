<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Switch_;

class BoundInformation extends Model
{
    use HasFactory;

    protected $table = 'bound_information_table';

    public $timestamps = false;
    protected $fillable = [
        'quoatation_product_id',
        'user_profile_id',
        'bound_date',
        'status',
    ];

    public function QuotationProduct()
    {
        return $this->belongsTo(QuotationProduct::class, 'quoatation_product_id');
    }

    public function getTotalSales()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $policies = $this->whereBetween('bound_date', [$startOfMonth, $endOfMonth])->get();
        $totalSales = $policies = 0 ? 0 : $policies->count();
        return $totalSales;
    }

    public function salesPercentageFromPreviousMonth()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $policies = $this->whereBetween('bound_date', [$startOfMonth, $endOfMonth])->get();
        $totalSales = $policies = 0 ? 0 : $policies->count();
        $previousMonth = now()->subMonth()->startOfMonth();
        $previousMonthEnd = now()->subMonth()->endOfMonth();
        $previousMonthPolicies = $this->whereBetween('bound_date', [$previousMonth, $previousMonthEnd])->get();
        // dd($previousMonthPolicies->count());
        $previousMonthTotalSales = $previousMonthPolicies = 0 ? 0 : $previousMonthPolicies->count();
        $percentage = $totalSales > 0 && $previousMonthTotalSales > 0 ? (($totalSales - $previousMonthTotalSales) / $previousMonthTotalSales) * 100 : 0;
        return number_format($percentage, 2);
    }

    public function getTotalSalesPartionByType()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $policies = $this->whereBetween('bound_date', [$startOfMonth, $endOfMonth])->get();
        $directNew = $policies->filter(function ($policy) {
            return strtolower($policy->status) === 'direct new';
        })->count();

        $directRenewals = $policies->filter(function ($policy) {
            return strtolower($policy->status) === 'direct renewals';
        })->count();

        $audit = $policies->filter(function ($policy) {
            return strtolower($policy->status) === 'audit';
        })->count();

        $endorsement = $policies->filter(function ($policy) {
            return strtolower($policy->status) === 'endorsement';
        })->count();

        $typeArr = [$directNew, $directRenewals, $audit, $endorsement];
        return $typeArr;
    }
}
