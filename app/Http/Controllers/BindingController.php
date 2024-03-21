<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
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
                $quote_comparison = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                $policy_number = '<a href="" id="'.$data->id.'" name="viewButton" class="viewRequestToBind">'.$quote_comparison->quote_no.'</a>';
                return $policy_number;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('total_cost', function($data){
                $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                return $quote_information->full_payment;
            })
            ->addColumn('requested_by', function($data) use($broker){
                $requested_by = $broker->where('quote_product_id', $data->id)->first();
                $userProfile = UserProfile::find($requested_by->user_profile_id)->fullAmericanName();
                return $userProfile;
            })
            ->addColumn('effective_date', function($data){
                $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                return $quote_information->effective_date;
            })
            ->rawColumns(['policy_number'])
            ->make(true);
        }
        return view('customer-service.binding.request-to-bind-view');
    }

    public function requestToBindInformation(Request $request)
    {
       $product = QuotationProduct::find($request->id);
       $market = $product->QouteComparison->where('recommended', 3)->first();
       $lead = $product->QuoteInformation->QuoteLead->leads;
       $paymentInformation = $market->PaymentInformation;
       $paymentCharged = $paymentInformation->paymentCharged;
       $marketName = QuoationMarket::find($market->quotation_market_id);
       $generalInformation = $lead->GeneralInformation;
       $userProfile = UserProfile::find($paymentCharged->user_profile_id);
       $userId = User::find($userProfile->user_id)->id;
       $mediaIds = $product->medias()->pluck('metadata_id')->toArray();
       $medias = Metadata::whereIn('id', $mediaIds)->get();
       return response()->json(['product' => $product, 'market' => $market, 'lead' => $lead, 'paymentInformation' => $paymentInformation, 'paymentCharged' => $paymentCharged, 'marketName' => $marketName, 'generalInformation' => $generalInformation, 'userProfile' => $userProfile, 'medias' => $medias, 'userId' => $userId]);
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
        {  try{

                $data = $request->all();
                $mediaIds = [];
                DB::beginTransaction();

                //file uploading
                $file = $data['attachedFiles'];
                $basename = $file->getClientOriginalName();
                $directoryPath = public_path('backend/assets/attacedFiles/binding/general-liability-insurance');
                $type = $file->getClientMimeType();
                $size = $file->getSize();
                if(!File::isDirectory($directoryPath)){
                    File::makeDirectory($directoryPath, 0777, true, true);
                }
                $file->move($directoryPath, $basename);
                $filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $basename;

                $metadata = new Metadata();
                $metadata->basename = $basename;
                $metadata->filename = $basename;
                $metadata->filepath = $filepath;
                $metadata->type = $type;
                $metadata->size = $size;
                $metadata->save();

                //policy details saving
                $policyDetails = new PolicyDetail();
                $policyDetails->quotation_product_id = $data['glHiddenInputId'];
                $policyDetails->policy_number = $data['glPolicyNumber'];
                $policyDetails->carrier = $data['carriersInput'];
                $policyDetails->market = $data['glMarketInput'];
                $policyDetails->payment_mode = $data['glPaymentTermInput'];
                $policyDetails->effective_date = $data['effectiveDate'];
                $policyDetails->expiration_date = $data['expirationDate'];
                $policyDetails->media_id =  $metadata->id;
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
                $generalLiabilitiesDetails->each_occurence = $data['eachOccurence'];
                $generalLiabilitiesDetails->damage_to_rented = $data['rentedDmg'];
                $generalLiabilitiesDetails->medical_expenses = $data['medExp'];
                $generalLiabilitiesDetails->per_adv_injury = $data['perAdvInjury'];
                $generalLiabilitiesDetails->gen_aggregate = $data['genAggregate'];
                $generalLiabilitiesDetails->product_comp = $data['comp'];
                $generalLiabilitiesDetails->status = $data['statusDropdowm'];
                $generalLiabilitiesDetails->save();

                //code for saving product
                $quotationProduct = QuotationProduct::find($data['glHiddenInputId']);
                $quotationProduct->status = 8;
                $quotationProduct->save();

                //code for quotation
                $quotationComparison = QuoteComparison::find($data['glHiddenQuoteId']);
                $quotationComparison->quote_no = $data['glPolicyNumber'];
                $quotationComparison->save();

                DB::commit();
                return response()->json(['success' => 'File uploaded successfully']);
            }catch(ValidationException $e){
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
            $quote_comparison = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
            $policy_number = '<a href="" id="'.$data->id.'" name="viewButton" class="viewBindingButton">'.$quote_comparison->quote_no.'</a>';
            return $policy_number;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('total_cost', function($data){
            $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
            return $quote_information->full_payment;
        })
        ->addColumn('requested_by', function($data) use($broker){
            $requested_by = $broker->where('quote_product_id', $data->id)->first();
            $userProfile = UserProfile::find($requested_by->user_profile_id)->fullAmericanName();
            return $userProfile;
        })
        ->addColumn('effective_date', function($data){
            $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
            return $quote_information->effective_date;
        })
        ->rawColumns(['policy_number'])
        ->make(true);
    }

}