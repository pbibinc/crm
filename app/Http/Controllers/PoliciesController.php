<?php

namespace App\Http\Controllers;

use App\Events\SendRenewalReminderEvent;
use App\Http\Controllers\Controller;
use App\Models\BuildersRiskPolicyDetails;
use App\Models\BusinessOwnersPolicyDetails;
use App\Models\CommercialAutoPolicy;
use App\Models\ExcessLiabilityInsurancePolicy;
use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\Metadata;
use App\Models\PaymentInformation;
use App\Models\PolicyAdditionalValue;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use App\Models\ToolsEquipmentPolicy;
use App\Models\UserProfile;
use App\Models\WorkersCompPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Switch_;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class PoliciesController extends Controller
{
    public function index(Request $request)
    {
        $data = PolicyDetail::orderBy('effective_date', 'desc');
        if($request->ajax())
        {
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                $companyNameLink = "<a href='/appointed-list/".$data->QuotationProduct->QuoteInformation->QuoteLead->leads->id."'>".$company_name."</a>";
                return $companyNameLink;
            })
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('total_cost', function($data){
                $totalCost = SelectedQuote::where('quotation_product_id', $data->QuotationProduct->id)->first();
                return $totalCost ? $totalCost->full_payment : '';
            })
            ->rawColumns(['company_name'])
            ->make(true);
        }
        return view('customer-service.policy.index');
    }

    public function getPolicyInformation(Request $request)
    {
        $policyDetail = PolicyDetail::find($request->id);
        $product = QuotationProduct::find($policyDetail->quotation_product_id);

        $lead = $product->QuoteInformation->QuoteLead->leads;
        $generalInformation = $lead->GeneralInformation;
        ;
        $selectedQuote = SelectedQuote::find($policyDetail->selected_quote_id);
        $paymentInformation = PaymentInformation::where('selected_quote_id', $selectedQuote->id)->first();
        $PolicyAdditionalValues = PolicyAdditionalValue::where('policy_details_id', $policyDetail->id)->get();
        $productPolicyInformation = null;
        $medias = $policyDetail->medias;
        switch ($product->product) {
            case 'General Liability':
                $productPolicyInformation = GeneralLiabilitiesPolicyDetails::where('policy_details_id', $policyDetail->id)->first();
                break;
            case 'Commercial Auto':
                $productPolicyInformation = CommercialAutoPolicy::where('policy_details_id', $policyDetail->id)->first();
                break;
            case 'Business Owners':
                $productPolicyInformation = BusinessOwnersPolicyDetails::where('policy_details_id', $policyDetail->id)->first();
                break;
            case 'Tools Equipment':
                $productPolicyInformation = ToolsEquipmentPolicy::where('policy_details_id', $policyDetail->id)->first();
                break;
            case 'Excess Liability':
                $productPolicyInformation = ExcessLiabilityInsurancePolicy::where('policy_details_id', $policyDetail->id)->first();
                break;
            case 'Workers Compensation':
                $productPolicyInformation = WorkersCompPolicy::where('policy_details_id', $policyDetail->id)->first();
                break;

            case 'Builders Risk':
                $productPolicyInformation = BuildersRiskPolicyDetails::where('policy_details_id', $policyDetail->id)->first();
                break;
        }
        return response()->json([
        'policy_detail' => $policyDetail,
        'product' => $product,
        'lead' => $lead,
        'general_information' => $generalInformation,
        'productPolicyInformation' => $productPolicyInformation,
        'selectedQuote' => $selectedQuote,
        'paymentInformation' => $paymentInformation,
        'policyAdditionalValues' => $PolicyAdditionalValues,
        'medias' => $medias
    ]);
    }

    public function newPolicyList(Request $request)
    {
        $policy = new PolicyDetail();
        $data = $policy->NewPoicyList();
        if($request->ajax())
        {
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->make(true);
        }
    }

    public function getPolicyList(Request $request)
    {
        if($request->ajax())
        {
            $quotationProduct = new PolicyDetail();
            $data = $quotationProduct->getPolicyDetailByLeadsId($request->input('id'));
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $policyNumber = PolicyDetail::where('quotation_product_id', $data->id)->first()->policy_number;
                return $policyNumber ? $policyNumber : '';
            })
            ->addColumn('carrier', function($data){
                $carrier = PolicyDetail::where('quotation_product_id', $data->id)->first()->carrier;
                return $carrier ? $carrier : '';
            })
            ->addColumn('market', function($data){
                $insurer = PolicyDetail::where('quotation_product_id', $data->id)->first()->market;
                return $insurer ? $insurer : '';
            })
            ->addColumn('effective_date', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->effective_date;
            })

            ->addColumn('status', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->status;
            })
            ->addColumn('expiration_date', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->expiration_date;
            })
            ->addColumn('action', function($data){
                $policyDetail = PolicyDetail::where('quotation_product_id', $data->id)->first();
                $quoteComparisonId = QuoteComparison::where('quotation_product_id', $policyDetail->QuotationProduct->id)->first()->id;

                $viewButton = '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$policyDetail->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                $renewQuoteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light renewQuoteButton" id="'.$data->id.'" data-quoteId="'.$quoteComparisonId.'"><i class="mdi mdi-account-reactivate"></i></button>';
                return $viewButton . ' ' . $renewQuoteButton . ' ' . $cancelButton;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getPolicyDetails(Request $request)
    {
        $data = $request->all();
        $policyDetail = PolicyDetail::where('quotation_product_id', $data['id']);

        return response()->json(['policy_detail' => $policyDetail]);
    }

    public function changeStatus(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $userProfileId = UserProfile::where('user_id', $userId)->first();
            $policyDetail = PolicyDetail::find($id);
            $policyDetail->status = $request['status'];
            $policyDetail->save();

            $quotationProduct = QuotationProduct::find($policyDetail->quotation_product_id);
            $leadId = $quotationProduct->QuoteInformation->QuoteLead->leads->id;
            if($request['status'] == "Renewal Quote"){
                event(new SendRenewalReminderEvent($leadId, $policyDetail->policy_number, $quotationProduct->product, $userProfileId->id));
            }
            DB::commit();
            return response()->json(['sucess' => 'Success']);
        }catch(\Exception $e){
            Log::info($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function getClienPolicyList(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getPolicyDetailByLeadId($request['id']);
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('total_cost', function($data){
                // $totalCost = SelectedQuote::find($data['policy']['selected_quote_id']);
                // return $totalCost ? $totalCost->full_payment : ' ';
                return ' ';
            })
            ->addColumn('policyStatus', function($data){
                $policyStatus = $data->status;
                $statusLabel = '';
                $class = '';
                switch ($policyStatus){
                    case 'issued':
                        $statusLabel = $policyStatus;
                        $class = 'bg-success';
                        break;
                    case 'Renewal Issued':
                        $statusLabel = $policyStatus;
                        $class = 'bg-success';
                        break;
                    case 'Rewrite':
                        $statusLabel = $policyStatus;
                        $class = 'bg-success';
                        break;
                    case 'Cancelled':
                        $statusLabel = $policyStatus;
                        $class = 'bg-danger';
                        break;
                    case 'Declined':
                        $statusLabel = $policyStatus;
                        $class = 'bg-danger';
                        break;
                    case 'Endorsing':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Notice of Cancellation':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Renewal Notice of Cancellation':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Intent':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Potential For Rewrite':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Not Interested':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Process Renewal':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Renewal Quote':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Renewal Quoted':
                        $statusLabel = $policyStatus;
                        $class = 'bg-success';
                        break;
                    case 'Renewal Quoted Assigned':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Follow Up Renewal':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Renewal Make A Payment':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Renewal Declined Payment':
                        $statusLabel = $policyStatus;
                        $class = 'bg-danger';
                        break;
                    case 'Renewal Request To Bind':
                        $statusLabel = $policyStatus;
                        $class = 'bg-warning';
                        break;
                    case 'Renewal Binding Declined':
                        $statusLabel = $policyStatus;
                        $class = 'bg-danger';
                        break;
                    case 'Renewal Payment Processed':
                        $statusLabel = $policyStatus;
                        $class = 'bg-success';
                        break;
                    case 'renewal issued':
                        $statusLabel = $policyStatus;
                        $class = 'bg-success';
                        break;
                    case 'old policy':
                        $statusLabel = $policyStatus;
                        $class = 'bg-secondary';
                        break;
                    default:
                        $statusLabel = $policyStatus;
                        $class = 'bg-secondary';
                        break;
                }
                // $status = now()->isAfter($effectiveDate) ? 'Inactive' : 'Active';
                // $class = now()->isAfter($effectiveDate) ? 'bg-danger' : 'bg-success';
                return "<span class='badge {$class}'>$statusLabel</span>";
            })
            ->addColumn('effectiveDate', function($data){
                $expirationDate = $data->expiration_date;
                $effectiveDate = $data->effective_date;
                // $status = now()->isAfter($expirationDate) ? expirationDate : 'Active';
                $class = now()->isAfter($expirationDate) ? 'bg-danger' : 'bg-success';
                return "<span class='badge {$class}'>$effectiveDate - $expirationDate</span>";
            })
            ->addColumn('action', function($data){
                $viewButton = '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
                $uploadFileButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light uploadPolicyFileButton" id="'.$data->id.'"><i class="ri-upload-2-line"></i></button>';
                return $viewButton. ' ' . $uploadFileButton;
            })
            ->rawColumns(['policyStatus', 'action', 'effectiveDate'])
            ->make(true);
        }
    }

    public function updatePolicyFile(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            //file uploading
            $file = $data['file'];
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/policy');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/policy' . '/'. $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();

            $policyDetail = PolicyDetail::find($data['id']);
            $policyDetail->media_id = $metadata->id;
            $policyDetail->save();

            DB::commit();
            return response()->json(['success' => 'Success']);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}