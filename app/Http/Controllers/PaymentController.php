<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\PaymentInformation;
use App\Models\QuoationMarket;
use App\Models\QuoteComparison;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $paymentInformation = new PaymentInformation();
        // $paymentInformationInstance = ;
        // dd($paymentInformationInstance);
        $paymentInformationData = $paymentInformation->AccountsForPayable();
        // $generalInformation = $paymentInformationData->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->GeneralInformation;
        if($request->ajax())
        {
            return DataTables::of($paymentInformationData)
            ->addIndexColumn()
            ->addColumn('payment_type', function($paymentInformationData){
                $paymentType = $paymentInformationData['data']->payment_type;
                return $paymentType;
            })
            ->addColumn('quote_no', function($paymentInformationData){
                $quoteNo = $paymentInformationData['data']->QuoteComparison->quote_no;
                return $quoteNo;
            })
            ->addColumn('company_name', function($paymentInformationData){
                $lead = $paymentInformationData['data']->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('product', function($paymentInformationData){
                $product = $paymentInformationData['data']->QuoteComparison->QuotationProduct->product;
                return $product;
            })
            ->addColumn('status', function($paymentInformationData){
                $status = $paymentInformationData['data']->QuoteComparison->QuotationProduct->status;
                return $status;
            })
            ->addColumn('requested_date', function($paymentInformationData){
                $requestedDate = $paymentInformationData['data']->created_at->format('M-d-Y H:i:s');
                return $requestedDate;
            })
            ->addColumn('requested_by', function($paymentInformationData){
                $requestedBy = $paymentInformationData['data']->QuoteComparison->QuotationProduct->brokerQuotation->fullAmericanName();
                return $requestedBy;
            })
            ->addColumn('action', function($paymentInformationData){
                $viewButton = '<button type="button" id="'.$paymentInformationData['data']->id.'" data-user-id="'. $paymentInformationData['data']->QuoteComparison->QuotationProduct->brokerQuotation->user_profile_id.'" class="btn btn-sm btn-primary viewPaymentInformationButton"><i class="ri-eye-line"></i></button>';
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

                //Updating quotation number
                $quoteComparison = $paymentInformation->QuoteComparison;
                $quoteComparison->quote_no = $request->quoteNumber;
                $quoteComparison->save();
            }else{
                $paymentInformation = new PaymentInformation();

                //Updating quotation number and setting status
                $quoteComparison = QuoteComparison::find($request->quoteComparisonId);
                $quoteComparison->quote_no = $request->quoteNumber;
                $quoteComparison->recommended = 2;
                $quoteComparison->save();

                //Updating quotation product status
                $paymentProduct = $quoteComparison->QuotationProduct;
                $paymentProduct->status = 9;
                $paymentProduct->save();
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
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function getPaymentInformation(Request $request)
    {
        $paymentInformation = PaymentInformation::find($request->id);
        $lead = $paymentInformation->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads;
        $generalInformation = $lead->GeneralInformation;
        $quoteComparison = $paymentInformation->QuoteComparison;
        $medias = $quoteComparison->media;
        $fullName = $generalInformation->customerFullName();
        $market = QuoationMarket::find($quoteComparison->quotation_market_id);
        $quotationProduct = $quoteComparison->QuotationProduct;
        $userId = User::find($quotationProduct->brokerQuotation->user_profile_id)->id;
        return response()->json(['paymentInformation' => $paymentInformation, 'lead' => $lead, 'generalInformation' => $generalInformation, 'quoteComparison' => $quoteComparison, 'market' => $market, 'fullName' => $fullName, 'quotationProduct' => $quotationProduct, 'medias' => $medias, 'userId' => $userId], 200);
    }
}