<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\PaymentInformation;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class BindingController extends Controller
{
//
    public function index(Request $request)
    {
        $markets = QuoationMarket::all()->sortBy('name');
        $carriers = Insurer::all()->sortBy('name');

        return view('customer-service.binding.index', compact('markets', 'carriers'));
    }

    public function requestToBind(Request $request)
    {
        if($request->ajax())
        {
            $quoationProduct = new QuotationProduct();
            $broker = new BrokerQuotation();
            $data = $quoationProduct->getRequestToBind();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                if($data->status == 17 || $data->status == 18)
                {
                    $policyDetail = PolicyDetail::where('quotation_product_id', $data->id)->where('status', 'Renewal Request To Bind')->first();
                    $selectedQuote = SelectedQuote::find($policyDetail->selected_quote_id);
                    $policy_number = '<a href="" id="'.$policyDetail->id.'" data-status="'.$data->status.'" name="viewButton" class="viewRequestToBind">'.$selectedQuote->quote_no.'</a>';
                }else{
                    $selectedQuote = SelectedQuote::where('quotation_product_id', $data->id)->first();
                    $policy_number = '<a href="" id="'.$data->id.'" data-status="'.$data->status.'" name="viewButton" class="viewRequestToBind">'.$selectedQuote->quote_no.'</a>';
                }
                return $policy_number;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('total_cost', function($data){
                $quote_information = SelectedQuote::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                return $quote_information->full_payment;
            })
            ->addColumn('requested_by', function($data) use($broker){
                $requested_by = $broker->where('quote_product_id', $data->id)->first();
                $userProfile = UserProfile::find($requested_by->user_profile_id)->fullAmericanName();
                return $userProfile;
            })
            ->addColumn('effective_date', function($data){
                $quote_information = SelectedQuote::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                return $quote_information->effective_date;
            })
            ->addColumn('bindingType', function($data){
                $statusLabel = '';
                $class = '';
                Switch ($data->status){
                    case 17:
                        $statusLabel = 'Direct Renewals';
                        $class = 'bg-warning';
                        break;
                    case 18:
                        $statusLabel = 'Resend Direct Renewals';
                        $class = 'bg-danger';
                        break;
                    case 6:
                        $statusLabel = 'Direct New';
                        $class = 'bg-warning';
                        break;
                    case 15:
                        $statusLabel = 'Resend Direct New';
                        $class = 'bg-danger';
                        break;
                    default:
                        $statusLabel = 'Unknown';
                        $class = 'bg-secondary';
                        break;
                }
                return '<span class="badge '.$class.'">'.$statusLabel.'</span>';
            })
            ->rawColumns(['policy_number', 'bindingType'])
            ->make(true);
        }
        return view('customer-service.binding.request-to-bind-view');
    }

    public function requestToBindInformation(Request $request)
    {
        if($request->type == 'renewal'){
            $policyDetail = PolicyDetail::find($request->id);
            $selectedQuote = SelectedQuote::find($policyDetail->selected_quote_id);
            $product = QuotationProduct::find($policyDetail->quotation_product_id);

        }else{
            $product = QuotationProduct::find($request->id);
            $selectedQuote = SelectedQuote::where('quotation_product_id', $request->id)->first();
        }

       $lead = $product->QuoteInformation->QuoteLead->leads;
       $paymentInformation = PaymentInformation::where('selected_quote_id', $selectedQuote->id)->first();
       $paymentCharged = $paymentInformation->paymentCharged;
       $marketName = QuoationMarket::find($selectedQuote->quotation_market_id);
       $generalInformation = $lead->GeneralInformation;
       $userProfile = UserProfile::find($paymentCharged->user_profile_id);
       $userId = User::find($userProfile->user_id)->id;
       $mediaIds = $product->medias()->pluck('metadata_id')->toArray();
       $medias = Metadata::whereIn('id', $mediaIds)->get();


       return response()->json(['product' => $product, 'market' => $selectedQuote, 'lead' => $lead, 'paymentInformation' => $paymentInformation, 'paymentCharged' => $paymentCharged, 'marketName' => $marketName, 'generalInformation' => $generalInformation, 'userProfile' => $userProfile, 'medias' => $medias, 'userId' => $userId]);
    }

    public function incompleteBindingList(Request $request)
    {
        $quoationProduct = new QuotationProduct();
        $data = $quoationProduct->getIncompleteBinding();
        if($request->ajax())
        {
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', function($data){
                $company_name = $data->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('requested_by', function($data){
                $broker = new BrokerQuotation();
                $requested_by = $broker->where('quote_product_id', $data->id)->first();
                $userProfile = UserProfile::find($requested_by->user_profile_id)->fullAmericanName();
                return $userProfile;
            })
            ->addColumn('policy_number', function($data){
                $quotationComparison = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                $policyNumber = '<a href="/appointed-list/'.$data->QuoteInformation->QuoteLead->leads->id.'"  id="'.$data->id.'" >'.$quotationComparison->quote_no.'</a>';
                return $policyNumber;

            })
            ->addColumn('total_cost', function($data){
                $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                return $quote_information->full_payment;
            })
            ->addColumn('effective_date', function($data){
                $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                return $quote_information->effective_date;
            })
            ->addColumn('market', function($data){
                $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                $market = QuoationMarket::find($quote_information->quotation_market_id);
                return $market->name;
            })
            ->rawColumns(['policy_number'])
            ->make(true);
        }
    }

    public function saveGeneralLiabilitiesPolicy(Request $request)
    {
        if($request->ajax())
        {

            try{
                $data = $request->all();
                $mediaIds = [];
                DB::beginTransaction();

                //file uploading
                $file = $data['attachedFiles'];
                $basename = $file->getClientOriginalName();
                $directoryPath = public_path('backend/assets/attacedFiles/policy');
                $type = $file->getClientMimeType();
                $size = $file->getSize();
                if(!File::isDirectory($directoryPath)){
                    File::makeDirectory($directoryPath, 0777, true, true);
                }
                $file->move($directoryPath, $basename);
                $filepath = 'backend/assets/attacedFiles/policy'. '/' . $basename;

                $metadata = new Metadata();
                $metadata->basename = $basename;
                $metadata->filename = $basename;
                $metadata->filepath = $filepath;
                $metadata->type = $type;
                $metadata->size = $size;
                $metadata->save();

                //code for saving product
                $quotationProduct = QuotationProduct::find($data['glHiddenInputId']);

                //policy details saving
                $policyDetails = new PolicyDetail();
                $policyDetails->selected_quote_id = $data['glHiddenQuoteId'];
                $policyDetails->quotation_product_id = $data['glHiddenInputId'];
                $policyDetails->policy_number = $data['glPolicyNumber'];
                $policyDetails->carrier = $data['carriersInput'];
                $policyDetails->market = $data['glMarketInput'];
                $policyDetails->payment_mode = $data['glPaymentTermInput'];
                $policyDetails->effective_date = $data['effectiveDate'];
                $policyDetails->expiration_date = $data['expirationDate'];
                $policyDetails->media_id =  $metadata->id;
                if($quotationProduct->status == 20){
                    $previousPolicy = PolicyDetail::where('quotation_product_id', $quotationProduct->id)->where('status', 'Renewal Request To Bind')->get();
                    foreach($previousPolicy as $policy){
                        $policy->status = 'old policy';
                        $policy->save();
                    }
                    $policyDetails->status = 'renewal issued';
                    $quotationProduct->status = 8;
                    $quotationProduct->save();
                }else{
                    $policyDetails->status = 'issued';
                    $quotationProduct->status = 8;
                    $quotationProduct->save();
                }
                $policyDetailSaving = $policyDetails->save();


                //general liabilities policy details saving
                $generalLiabilitiesDetails = new GeneralLiabilitiesPolicyDetails();
                $generalLiabilitiesDetails->policy_details_id  = $policyDetails->id;
                $generalLiabilitiesDetails->is_commercial_gl = isset($data['commercialGl']) && $data['commercialGl'] ? 1 : 0;
                $generalLiabilitiesDetails->is_occur = isset($data['occur']) && $data['occur'] ? 1 : 0;
                $generalLiabilitiesDetails->is_policy = isset($data['policy']) && $data['policy'] ? 1 : 0;
                $generalLiabilitiesDetails->is_project = isset($data['project']) && $data['project']  ? 1 : 0;
                $generalLiabilitiesDetails->is_loc = isset($data['loc']) && $data['loc'] ? 1 : 0;
                $generalLiabilitiesDetails->is_additional_insd = isset($data['glAddlInsd']) && $data['glAddlInsd'] ? 1 : 0;
                $generalLiabilitiesDetails->is_subr_wvd = isset($data['glSubrWvd']) && $data['glSubrWvd'] ? 1 : 0;
                $generalLiabilitiesDetails->is_claims_made = isset($data['claimsMade']) && $data['claimsMade'] ? 1 : 0;
                $generalLiabilitiesDetails->each_occurence = $data['eachOccurence'];
                $generalLiabilitiesDetails->damage_to_rented = $data['rentedDmg'];
                $generalLiabilitiesDetails->medical_expenses = $data['medExp'];
                $generalLiabilitiesDetails->per_adv_injury = $data['perAdvInjury'];
                $generalLiabilitiesDetails->gen_aggregate = $data['genAggregate'];
                $generalLiabilitiesDetails->product_comp = $data['comp'];
                $generalLiabilitiesDetails->status = 'issued';
                $generalLiabilitiesDetails->save();



                //code for quotation
                $quotationComparison = SelectedQuote::find($data['glHiddenQuoteId']);
                $quotationComparison->quote_no = $data['glPolicyNumber'];
                $quotationComparison->save();

                DB::commit();
                return response()->json(['success' => 'File uploaded successfully']);
            }catch(ValidationException $e){
                DB::rollBack();
                return response()->json([
                    'errors' => $e->validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }
        }
    }

    public function bindingViewList(Request $request)
    {
        $quotationProduct = new QuotationProduct();
        $data = $quotationProduct->getBinding();
        $broker = new BrokerQuotation();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('policy_number', function($data){
            if($data->status == 19){
                $policyDetail = PolicyDetail::where('quotation_product_id', $data->id)->where('status', 'Renewal Request To Bind')->first();
                $selectedQuote = SelectedQuote::find($policyDetail->selected_quote_id);
                $policy_number = '<a href="" id="'.$policyDetail->id.'" data-status="'.$data->status.'" name="viewButton" class="viewBindingButton" type="renewal">'.$selectedQuote->quote_no.'</a>';
            }else{
                $selectedQuote = SelectedQuote::where('quotation_product_id', $data->id)->first();
                $policy_number = '<a href="" id="'.$data->id.'" data-status="'.$data->status.'" name="viewButton" class="viewBindingButton" type="new">'.$selectedQuote->quote_no.'</a>';
            }
            return $policy_number;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('total_cost', function($data){
            $quote_information = SelectedQuote::where('quotation_product_id', $data->id)->first();
            return $quote_information->full_payment;
        })
        ->addColumn('requested_by', function($data) use($broker){
            $requested_by = $broker->where('quote_product_id', $data->id)->first();
            $userProfile = UserProfile::find($requested_by->user_profile_id)->fullAmericanName();
            return $userProfile;
        })
        ->addColumn('effective_date', function($data){
            $quote_information = SelectedQuote::where('quotation_product_id', $data->id)->first();
            return $quote_information->effective_date;
        })
        ->rawColumns(['policy_number'])
        ->make(true);
    }

}