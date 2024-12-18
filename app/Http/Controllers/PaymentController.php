<?php

namespace App\Http\Controllers;

use App\Events\HistoryLogsEvent;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $paymentInformation = new PaymentInformation();
        $paymentInformationData = $paymentInformation->whereIn('status', ['pending', 'declined', 'resend'])->get();
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
            ->addColumn('payment-information_status', function($paymentInformationData){
                $status = $paymentInformationData->status;
                $statusLabel = '';
                $class = '';
                Switch ($status) {
                    case 'pending':
                        $statusLabel ='Pending';
                        $class = 'bg-warning';
                        break;
                    case 'charged':
                        $statusLabel = 'Paid';
                        $class = 'bg-success';
                        break;
                    case 'declined':
                        $statusLabel = 'Declined';
                        $class = 'bg-danger';
                        break;
                    case 'resend':
                        $statusLabel = 'Resend';
                        $class = 'bg-warning';
                        break;
                    default:
                        $statusLabel = 'Unknown';
                        $class = 'bg-secondary';
                        break;
                }
                return "<span class='badge {$class}'>{$statusLabel}</span>";
            })
            ->addColumn('requested_date', function($paymentInformationData){
                $requestedDate = $paymentInformationData->created_at->format('M-d-Y H:i:s');
                return $requestedDate;
            })
            ->addColumn('requested_by', function($paymentInformationData){
                $requestedBy = $paymentInformationData->RequestedBy ? $paymentInformationData->RequestedBy->fullAmericanName() :'N/A';
                return $requestedBy;
            })
            ->addColumn('action', function($paymentInformationData){
                $leadId = $paymentInformationData->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewFormButton = '<button type="button" id="'.$paymentInformationData->id.'" data-user-id="'. $paymentInformationData->QuoteComparison->QuotationProduct->brokerQuotation->user_profile_id.'" class="btn btn-sm btn-success viewPaymentInformationButton"><i class=" ri-file-list-3-line"></i></button>';
                $viewProfileButton = '<a href="'.route('appointed-list-profile-view', ['leadsId' => $paymentInformationData->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->id]).'" class="btn btn-sm btn-primary"><i class="ri-eye-line"></i></a>';
                $noteButton = '<button type="button" id="'.$leadId.'" class="btn btn-sm btn-info viewNoteButton"><i class="ri-message-2-line"></i></button>';
                return $viewFormButton . ' ' .$viewProfileButton . ' ' . $noteButton;
            })
            ->rawColumns(['action', 'payment-information_status'])
            ->make(true);
        }
        return view('admin.accounting.accounts-revceivable.index');
    }

    public function storePaymentInformation(Request $request)
    {
        try{
            DB::beginTransaction();
            $userProfileId = Auth::user()->userProfile->id;
            $request->validate([
                'paymentType' => 'required',
                'paymentMethod' => 'required',
                // 'insuranceCompliance' => 'required',
                'chargedAmount' => 'required',
                'note' => 'required',
            ]);
            if($request->paymentInformationId){
                $paymentInformation = PaymentInformation::find($request->paymentInformationId);
                if($request->paymentInformationAction == 'Request A Payment'){
                    $paymentInformation->status = 'resend';
                }
                $selectedQuote = $paymentInformation->SelectedQuote;
                $selectedQuote->quote_no = $request->quoteNumber;
                $selectedQuote->save();
            }else{
                $paymentInformation = new PaymentInformation();
            }
            if($request->paymentType == 'Audit' || $request->paymentType == 'Monthly Payment'){

                $paymentInformation->payment_term = 'PIF';
                $paymentInformation->compliance_by = 'N/A';
            }else{

                $selectedQuote = SelectedQuote::find($request->quoteComparisonId);
                $selectedPricingBreakdown = $selectedQuote->SelectedPricingBreakDown;
                $paymentInformation->payment_term = $request->paymentTerm;
                //Updating quotation product status

                $paymentProduct = $selectedQuote->QuotationProduct;
                $paymentProduct->status = 9;
                $paymentProduct->save();

                $paymentInformation->compliance_by = $request->insuranceCompliance;
            }

            //direct renewals make a payment
            if($request->paymentType == 'Direct Renewals'){
                $policyDetails = PolicyDetail::find($request->policyDetailId);
                if($policyDetails->status = 'Process Quoted Renewal')
                {
                    $policyDetails->status = 'Renewal Make A Payment';
                }
                $policyDetails->save();
            }else if($request->paymentType == 'Rewrite/Recovery'){
                $policyDetails = PolicyDetail::find($request->policyDetailId);
                $policyDetails->status = 'For Rewrite Make A Payment';
                $policyDetails->save();
            }

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

            $paymentInformation->requested_by = $userProfileId;
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




            event(new HistoryLogsEvent($lead->id, $userProfileId, 'Payment Information', $paymentInformation->payment_type . ' ' . 'Payment Information Requested'));

            DB::commit();
            return response()->json(['success' => 'Payment Information Successfully Saved!'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function declinedPayment(Request $request)
    {
        try{
            DB::beginTransaction();
            $paymentInformation = PaymentInformation::find($request->paymentInformationId);
            $paymentInformation->status = 'declined';
            $paymentInformation->save();

            event(new HistoryLogsEvent($paymentInformation->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->id, Auth::user()->userProfile->id, 'Payment Information', $paymentInformation->payment_type . ' ' . 'Payment Information Declined'));
            DB::commit();
            return response()->json(['success' => 'Payment Information has been declined.'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function resendPaymentInformation(Request $request)
    {

    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();
            $paymentInformation = PaymentInformation::find($id);
            $paymentCharged = $paymentInformation->PaymentCharged;
            if($paymentCharged){
                $paymentCharged->delete();
            }
            $paymentInformation->delete();
            DB::commit();
            return response()->json(['success' => 'Payment Information has been deleted.'], 200);
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
        $quoteComparison = SelectedQuote::find($paymentInformation->selected_quote_id);

        $medias = $paymentInformation->QuoteComparison->media;
        $fullName = $generalInformation->customerFullName();
        $market = QuoationMarket::find($quoteComparison->quotation_market_id);
        $quotationProduct = $paymentInformation->QuoteComparison->QuotationProduct;
        $userId = User::find($quotationProduct->brokerQuotation->user_profile_id)->id;
        return response()->json(['paymentInformation' => $paymentInformation, 'lead' => $lead, 'generalInformation' => $generalInformation, 'quoteComparison' => $quoteComparison, 'market' => $market, 'fullName' => $fullName, 'quotationProduct' => $quotationProduct, 'medias' => $medias, 'userId' => $userId], 200);
    }

}