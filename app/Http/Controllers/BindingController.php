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
        // if($request->ajax())
        // {
        // return DataTables::of($confirmedProduct)
        //     ->addIndexColumn()
        //     ->addColumn('company_name', function($confirmedProduct){
        //         $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads->company_name;
        //         return $lead;
        //     })
        //     ->addColumn('requestedBy', function($confirmedProduct) use ($quotationProduct){
        //         $brokerQuotation = $quotationProduct->where('quote_product_id', $confirmedProduct->id)->first();
        //         $userProfile = UserProfile::find($brokerQuotation->user_profile_id)->fullAmericanName();
        //         return $userProfile;
        //     })
        //     ->addColumn('status', function($confirmedProduct){
        //         $status = $confirmedProduct->status;
        //         if($status == 11){
        //             $status = '<span class="badge bg-success">Bound</span>';
        //         }else if($status == 14){
        //             $status = '<span class="badge bg-danger">Declined</span>';

        //         }else if($status == 15){
        //             $status = '<span class="badge bg-info">Resend Request</span>';

        //         }else{
        //             $status = '<span class="badge bg-warning">Request To Bind</span>';
        //         }
        //         return $status;
        //     })
        //     ->addColumn('action', function($confirmedProduct){
        //         $quote = QuoteComparison::where('quotation_product_id', $confirmedProduct->id)->where('recommended', 3)->first();
        //         $paymentInformation = $quote->PaymentInformation;
        //         // dd($paymentInformation);
        //         $paymentInformationData = $paymentInformation ? $paymentInformation->toJson() : '{}';
        //         $quoteData = $quote ? $quote->toJson() : '{}';
        //         $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads;
        //         $mediaIds = $confirmedProduct->medias()->pluck('metadata_id')->toArray();
        //         $media = Metadata::whereIn('id', $mediaIds)->get();
        //         $marketName = QuoationMarket::find($quote->quotation_market_id);
        //         $userProfile = UserProfile::find($paymentInformation->paymentCharged->user_profile_id);
        //         $profileViewRoute = route('appointed-list-profile-view', ['leadsId' => $lead->id]);
        //         $viewButton = '<button type="button"
        //         id="'.$confirmedProduct->id.'"
        //         data-product="'.$confirmedProduct->product.'"
        //         data-paymentInformation = "'.htmlspecialchars(json_encode($paymentInformation), ENT_QUOTES, 'UTF-8').'"
        //         data-quote="'.htmlspecialchars(json_encode($quote), ENT_QUOTES, 'UTF-8').'"
        //         data-lead="'.htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8').'"
        //         data-paymentCharged="'.htmlspecialchars(json_encode($paymentInformation->paymentCharged), ENT_QUOTES, 'UTF-8').'"
        //         data-generalInformation = "'.htmlspecialchars(json_encode($lead->GeneralInformation), ENT_QUOTES, 'UTF-8').'"
        //         data-media=  "'.htmlspecialchars(json_encode($media), ENT_QUOTES, 'UTF-8').'"
        //         data-marketName = "'.$marketName->name.'"
        //         data-status = "'.$confirmedProduct->status.'"
        //         data-userProfileName = "'.$userProfile->fullAmericanName().'"
        //         class="btn btn-sm btn-primary viewBindingButton"><i class="ri-eye-line"></i></button>';

        //         $bindButton = '<button type="button"
        //         id="'.$confirmedProduct->id.'"
        //         data-product="'.$confirmedProduct->product.'"
        //         data-companyName = "'.$confirmedProduct->QuoteInformation->QuoteLead->leads->company_name.'"
        //         data-quote="'.htmlspecialchars(json_encode($quote), ENT_QUOTES, 'UTF-8').'"
        //         data-marketName ="'.$marketName->name.'"
        //         class="bindButton btn btn-sm btn-success"
        //         name="bindButton"><i class="ri-share-box-line"></i></button>';

        //         $viewProfileButton = '<a href="'.$profileViewRoute.'" class="viiew btn btn-success btn-sm" id="'.$lead->id.'" name"view"><i class=" ri-article-line"></i></a>';

        //         return $bindButton  . ' ' .  $viewButton . ' ' . $viewProfileButton;
        //     })
        //     ->rawColumns(['action', 'status'])
        //     ->make(true);
        // }
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
;
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

}
