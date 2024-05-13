<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\PaymentInformation;
use App\Models\PolicyDetail;
use App\Models\PricingBreakdown;
use App\Models\QuoationMarket;
use App\Models\QuoteComparison;
use App\Models\SelectedPricingBreakDown;
use App\Models\SelectedQuote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $paymentInformation = new PaymentInformation();
        $paymentInformationData = $paymentInformation->where('status', 'pending')->get();
        if($request->ajax())
        {
            return DataTables::of($paymentInformationData)
            ->addIndexColumn()
            ->addColumn('payment_type', function($paymentInformationData){
                $paymentType = $paymentInformationData->payment_type;
                return $paymentType;
            })
            ->addColumn('quote_no', function($paymentInformationData){
                $quoteNo = $paymentInformationData->QuoteComparison->quote_no;
                return $quoteNo;
            })
            ->addColumn('company_name', function($paymentInformationData){
                $lead = $paymentInformationData->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('product', function($paymentInformationData){
                $product = $paymentInformationData->QuoteComparison->QuotationProduct->product;
                return $product;
            })
            ->addColumn('status', function($paymentInformationData){
                $status = $paymentInformationData->QuoteComparison->QuotationProduct->status;
                return $status;
            })
            ->addColumn('requested_date', function($paymentInformationData){
                $requestedDate = $paymentInformationData->created_at->format('M-d-Y H:i:s');
                return $requestedDate;
            })
            ->addColumn('requested_by', function($paymentInformationData){
                $requestedBy = $paymentInformationData->QuoteComparison->QuotationProduct->brokerQuotation->fullAmericanName();
                return $requestedBy;
            })
            ->addColumn('action', function($paymentInformationData){
                $viewButton = '<button type="button" id="'.$paymentInformationData->id.'" data-user-id="'. $paymentInformationData->QuoteComparison->QuotationProduct->brokerQuotation->user_profile_id.'" class="btn btn-sm btn-primary viewPaymentInformationButton"><i class="ri-eye-line"></i></button>';
                return $viewButton;
            })
            ->make(true);
        }
        return view('admin.accounting.accounts-revceivable.index');
    }

    public function storePaymentInformation(Request $request)
    {
        try{
            DB::beginTransaction();
            $request->validate([
                'paymentType' => 'required',
                'paymentMethod' => 'required',
                'insuranceCompliance' => 'required',
                'chargedAmount' => 'required',
                'note' => 'required',
            ]);
            if($request->paymentInformationId){
                $paymentInformation = PaymentInformation::find($request->paymentInformationId);
                $quoteComparison = $paymentInformation->QuoteComparison;
                $quoteComparison->quote_no = $request->quoteNumber;
                $quoteComparison->save();
            }else{
                $paymentInformation = new PaymentInformation();

                //Updating quotation number and setting status
                // $quoteComparison = QuoteComparison::find($request->quoteComparisonId);
                // $quoteComparison->quote_no = $request->quoteNumber;
                // $quoteComparison->recommended = 2;
                // $quoteComparison->save();
                $selectedQuote = SelectedQuote::find($request->quoteComparisonId);
                $selectedPricingBreakdown = $selectedQuote->SelectedPricingBreakDown;

                // SelectedPricingBreakDown::create($pricingBreakDown->toArray());
                // SelectedQuote::create($quoteComparison->toArray());

                //Updating quotation product status
                $paymentProduct = $selectedQuote->QuotationProduct;
                $paymentProduct->status = 9;
                $paymentProduct->save();
            }

            if($request->paymentType == 'Direct Renewals'){
                $policyDetails = PolicyDetail::where('quotation_product_id', $selectedQuote->QuotationProduct->id)->first();
                $policyDetails->status = 'Renewal Make A Payment';
                $policyDetails->save();
            }

            //Saving Payment Information
            $paymentInformation->quote_comparison_id = $request->quoteComparisonId;
            $paymentInformation->payment_type = $request->paymentType;
            if($request->paymentMethod == 'Credit Card'){
                if($request->cardType == 'Other'){
                    $paymentInformation->payment_method = $request->otherCard;
                }else{
                    $paymentInformation->payment_method = $request->cardType;
                }
            }else{
                $paymentInformation->payment_method = $request->paymentMethod;
            }
            $paymentInformation->payment_term = $request->paymentTerm;
            $paymentInformation->compliance_by = $request->insuranceCompliance;
            $paymentInformation->amount_to_charged = $request->chargedAmount;
            $paymentInformation->note = $request->note;
            $paymentInformation->selected_quote_id = $request->selectedQuoteId;
            $paymentInformation->save();

            //updating Lead Details
            $lead = Lead::find($request->leadsId);
            $lead->company_name = $request->companyName;
            $lead->save();

            //updating General Information
            $generalInformation = GeneralInformation::find($request->generalInformationId);
            $generalInformation->email_address = $request->emailAddress;
            $generalInformation->firstName = $request->firstName;
            $generalInformation->lastName = $request->lastName;
            $generalInformation->save();


            DB::commit();
            return response()->json(['success' => 'Payment Information Successfully Saved!'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPaymentInformation(Request $request)
    {
        $paymentInformation = PaymentInformation::find($request->id);
        $lead = $paymentInformation->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads;
        $generalInformation = $lead->GeneralInformation;
        $quoteComparison = SelectedQuote::where('quotation_product_id', $paymentInformation->QuoteComparison->QuotationProduct->id)->first();

        $medias = $paymentInformation->QuoteComparison->media;
        $fullName = $generalInformation->customerFullName();
        $market = QuoationMarket::find($quoteComparison->quotation_market_id);
        $quotationProduct = $paymentInformation->QuoteComparison->QuotationProduct;
        $userId = User::find($quotationProduct->brokerQuotation->user_profile_id)->id;
        return response()->json(['paymentInformation' => $paymentInformation, 'lead' => $lead, 'generalInformation' => $generalInformation, 'quoteComparison' => $quoteComparison, 'market' => $market, 'fullName' => $fullName, 'quotationProduct' => $quotationProduct, 'medias' => $medias, 'userId' => $userId], 200);
    }
}