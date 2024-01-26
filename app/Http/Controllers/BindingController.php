<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
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
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $confirmedProduct = $quotationProduct->getProductToBind($userProfileId);
        if($request->ajax())
        {
        return DataTables::of($confirmedProduct)
            ->addIndexColumn()
            ->addColumn('company_name', function($confirmedProduct){
                $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('requestedBy', function($confirmedProduct) use ($quotationProduct){
                $brokerQuotation = $quotationProduct->where('quote_product_id', $confirmedProduct->id)->first();
                $userProfile = UserProfile::find($brokerQuotation->user_profile_id)->fullAmericanName();
                return $userProfile;
            })
            ->addColumn('status', function($confirmedProduct){
                $status = $confirmedProduct->status;
                if($status == 11){

                    $status = '<span class="badge bg-success">Bound</span>';
                }else{
                    $status = '<span class="badge bg-warning">Request To Bind</span>';
                }
                return $status;
            })
            ->addColumn('action', function($confirmedProduct){
                $quote = QuoteComparison::where('quotation_product_id', $confirmedProduct->id)->where('recommended', 3)->first();
                $paymentInformation = $quote->PaymentInformation;
                $paymentInformationData = $paymentInformation ? $paymentInformation->toJson() : '{}';
                $quoteData = $quote ? $quote->toJson() : '{}';
                $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads;
                $mediaIds = $confirmedProduct->medias()->pluck('metadata_id')->toArray();
                $media = Metadata::whereIn('id', $mediaIds)->get();
                $marketName = QuoationMarket::find($quote->quotation_market_id);
                $userProfile = UserProfile::find($paymentInformation->paymentCharged->user_profile_id);
                $profileViewRoute = route('appointed-list-profile-view', ['leadsId' => $lead->id]);
                $viewButton = '<button type="button"
                id="'.$confirmedProduct->id.'"
                data-product="'.$confirmedProduct->product.'"
                data-paymentInformation = "'.htmlspecialchars(json_encode($paymentInformation), ENT_QUOTES, 'UTF-8').'"
                data-quote="'.htmlspecialchars(json_encode($quote), ENT_QUOTES, 'UTF-8').'"
                data-lead="'.htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8').'"
                data-paymentCharged="'.htmlspecialchars(json_encode($paymentInformation->paymentCharged), ENT_QUOTES, 'UTF-8').'"
                data-generalInformation = "'.htmlspecialchars(json_encode($lead->GeneralInformation), ENT_QUOTES, 'UTF-8').'"
                data-media=  "'.htmlspecialchars(json_encode($media), ENT_QUOTES, 'UTF-8').'"
                data-marketName = "'.$marketName->name.'"

                data-userProfileName = "'.$userProfile->fullAmericanName().'"

                class="btn btn-sm btn-primary viewBindingButton"><i class="ri-eye-line"></i></button>';

                $bindButton = '<button type="button"
                id="'.$confirmedProduct->id.'"
                data-product="'.$confirmedProduct->product.'"
                data-companyName = "'.$confirmedProduct->QuoteInformation->QuoteLead->leads->company_name.'"
                data-paymentInformation="'.htmlspecialchars(json_encode($paymentInformation), ENT_QUOTES, 'UTF-8').'"
                data-quote="'.htmlspecialchars(json_encode($quote), ENT_QUOTES, 'UTF-8').'"
                class="bindButton btn btn-sm btn-success"
                name="bindButton"><i class="ri-share-box-line"></i></button>';

                $viewProfileButton = '<a href="'.$profileViewRoute.'" class="viiew btn btn-success btn-sm" id="'.$lead->id.'" name"view"><i class=" ri-article-line"></i></a>';

                return $bindButton  . ' ' .  $viewButton . ' ' . $viewProfileButton;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
        }
        return view('customer-service.binding.index');
    }

    public function saveGeneralLiabilitiesPolicy(Request $request)
    {
        if($request->ajax())
        {  try{
                $data = $request->all();
                DB::beginTransaction();
                $policyDetails = new PolicyDetail();
                $policyDetails->quotation_product_id = $data['hiddenInputId'];
                $policyDetails->policy_number = $data['policyNumber'];
                $policyDetails->carrier = $data['carriersInput'];
                $policyDetails->insurer = $data['insurerInput'];
                $policyDetails->payment_mode = $data['paymentModeInput'];
                $policyDetailSaving = $policyDetails->save();
                if($policyDetailSaving){
                    $file = $data['attachedFile'];
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

                    $generalLiabilitiesDetails = new GeneralLiabilitiesPolicyDetails();
                    $generalLiabilitiesDetails->policy_details_id  = $policyDetails->id;
                    $generalLiabilitiesDetails->is_commercial_gl = isset($data['commercialGl']) && $data['commercialGl'] ? 1 : 0;
                    $generalLiabilitiesDetails->is_occur = isset($data['occur']) && $data['occur'] ? 1 : 0;
                    $generalLiabilitiesDetails->is_policy = isset($data['policy']) && $data['policy'] ? 1 : 0;
                    $generalLiabilitiesDetails->is_project = isset($data['project']) && $data['project']  ? 1 : 0;
                    $generalLiabilitiesDetails->is_loc = isset($data['loc']) && $data['loc'] ? 1 : 0;
                    $generalLiabilitiesDetails->is_additional_insd = isset($data['addlInsdL']) && $data['addlInsdL'] ? 1 : 0;
                    $generalLiabilitiesDetails->is_subr_wvd = isset($data['subrWvd']) && $data['subrWvd'] ? 1 : 0;
                    $generalLiabilitiesDetails->each_occurence = $data['eachOccurence'];
                    $generalLiabilitiesDetails->damage_to_rented = $data['rentedDmg'];
                    $generalLiabilitiesDetails->medical_expenses = $data['medExp'];
                    $generalLiabilitiesDetails->per_adv_injury = $data['perAdvInjury'];
                    $generalLiabilitiesDetails->gen_aggregate = $data['genAggregate'];
                    $generalLiabilitiesDetails->product_comp = $data['comp'];
                    $generalLiabilitiesDetails->effective_date = $data['effectiveDate'];
                    $generalLiabilitiesDetails->expiry_date = $data['expirationDate'];
                    $generalLiabilitiesDetails->status = $data['statusDropdowm'];
                    $generalLiabilitiesDetails->media_id = $metadata->id;
                    $generalLiabilitiesDetails->save();

                    $quotationProduct = QuotationProduct::find($data['hiddenInputId']);
                    $quotationProduct->status = 8;
                    $quotationProduct->save();

                    $leadId = $quotationProduct->QuoteInformation->QuoteLead->leads->id;
                    $lead = Lead::find($leadId);
                    $lead->status = 10;
                    $lead->save();
                }
                DB::commit();
            }catch(ValidationException $e){
                return response()->json([
                    'errors' => $e->validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }
        }
    }


}