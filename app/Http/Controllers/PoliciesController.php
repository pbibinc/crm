<?php

namespace App\Http\Controllers;

use App\Events\SendRenewalReminderEvent;
use App\Http\Controllers\Controller;
use App\Models\BuildersRiskPolicyDetails;
use App\Models\BusinessOwnersPolicyDetails;
use App\Models\CancellationReport;
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
                $selectedQuote = SelectedQuote::find($policyDetail->selected_quote_id);

                $viewButton = '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$policyDetail->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                $renewQuoteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light renewQuoteButton" id="'.$data->id.'" data-quoteId="'.$selectedQuote->id.'"><i class="mdi mdi-account-reactivate"></i></button>';
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
            return response()->json(['sucess' => 'Success'], 200);
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
                $statusLabel = $policyStatus;;
                $class = 'bg-secondary';
                switch ($policyStatus) {
                    case 'issued':
                    case 'Renewal Issued':
                    case 'Rewrite':
                    case 'Renewal Quoted':
                    case 'renewal issued':
                    case 'Renewal Payment Processed':
                    case 'Reinstate':
                    case 'recovered policy issued':
                        $class = 'bg-success';
                        break;

                    case 'Cancelled':
                    case 'Declined':
                    case 'Renewal Declined Payment':
                    case 'Renewal Binding Declined':
                    case 'Cancellation Request By Customer':
                        $class = 'bg-danger';
                        break;

                    case 'Endorsing':
                    case 'Notice of Cancellation':
                    case 'Renewal Notice of Cancellation':
                    case 'Intent':
                    case 'Potential For Rewrite':
                    case 'Not Interested':
                    case 'Process Renewal':
                    case 'Renewal Quote':
                    case 'Renewal Quoted Assigned':
                    case 'Follow Up Renewal':
                    case 'Renewal Make A Payment':
                    case 'Renewal Request To Bind':
                    case 'Rewrite Request To Bind':
                    case 'For Rewrite Quotation':
                    case 'pending':
                    case 'Subject For Rewrite':
                    case 'Process Quoted Renewal':
                        $class = 'bg-warning';
                        break;

                    case 'old policy':
                        $class = 'bg-secondary';
                        break;
                }
                // $status = now()->isAfter($effectiveDate) ? 'Inactive' : 'Active';
                // $class = now()->isAfter($effectiveDate) ? 'bg-danger' : 'bg-success';
                // Special case for 'Notice of Cancellation'
                if ($policyStatus === 'Notice of Cancellation') {
                   $cancellationStatus = CancellationReport::where('policy_details_id', $data->id)->latest()->first();
                   $statusLabel = $cancellationStatus->type_of_cancellation ?? $policyStatus;
                }
                return "<span class='badge {$class}'>$statusLabel</span>";
            })
            ->addColumn('effectiveDate', function($data){
                $expirationDate = $data->expiration_date;
                $effectiveDate = $data->effective_date;

                $class = now()->isAfter($expirationDate) || $data->status == 'Dead Policy'  ? 'bg-danger' : 'bg-success';
                return $expirationDate;
            })
            ->addColumn('action', function($data){
                if($data->status == 'Intent' || $data->status == 'Notice of Cancellation'){
                    $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light intentCancelButton" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                }else{
                    $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                }
                $viewButton = '<button type="button" class="btn btn-outline-primary btn-sm waves-effect waves-light viewButton" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-eye-line"></i></button>';

                $uploadFileButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light uploadPolicyFileButton" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-upload-2-line"></i></button>';

                $editButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light editButton" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-pencil-line"></i></button>';

                $auditInformationButton = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light auditInformationButton" id="'.$data->id.'"><i class="ri-file-list-3-line"></i></button>';
                // $dropdown = '
                // <div class="dropdown">
                //     <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                //         Actions
                //     </button>
                //     <ul class="dropdown-menu" aria-labelledby="actionMenu">
                //         <li><a class="dropdown-item auditInformationButton text-warning" href="#" id="'.$data->id.'"><i class="mdi mdi-book-search-outline"></i> Audit Info</a></li>
                //         <li><a class="dropdown-item '.($data->status == 'Intent' || $data->status == 'Notice of Cancellation' ? 'intentCancelButton' : 'cancelButton').' text-danger" href="#" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i> Cancel</a></li>
                //     </ul>
                // </div>';
                // return $viewButton. ' ' .  ' '. $editButton . ' ' . $uploadFileButton .  ' '. $auditInformationButton . ' ' . $cancelButton;
                $dropdown = '
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-sm dropdown-toggle" type="button" id="actionMenu' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6c757d; color: white; border: none; padding: 5px; font-size: 16px; line-height: 1; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                        &#x2022;&#x2022;&#x2022;
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionMenu' . $data->id . '" style="min-width: 100px;">
                        <li><a class="dropdown-item uploadPolicyFileButton text-success" href="#" id="' . $data->id . '"><i class="ri-upload-2-line"></i> Upload File</a></li>
                        <li><a class="dropdown-item auditInformationButton text-warning" href="#" id="' . $data->id . '"><i class="mdi mdi-book-search-outline"></i> Audit Info</a></li>
                        <li><a class="dropdown-item ' . ($data->status == 'Intent' || $data->status == 'Notice of Cancellation' ? 'intentCancelButton' : 'cancelButton') . ' text-danger" href="#" id="' . $data->id . '"><i class="mdi mdi-book-cancel-outline"></i> Cancel</a></li>
                    </ul>
                </div>';



                // $dropdown = '
                // <div class="dropdown">
                //     <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionMenu' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 2px 6px; font-size: 12px;">
                //         Actions
                //     </button>
                //     <ul class="dropdown-menu" aria-labelledby="actionMenu' . $data->id . '" style="max-height: 150px; overflow-y: auto; min-width: 100px;">
                //         <li><a class="dropdown-item viewButton text-primary" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="ri-eye-line"></i> View</a></li>
                //         <li><a class="dropdown-item editButton text-info" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="ri-pencil-line"></i> Edit</a></li>
                //         <li><a class="dropdown-item uploadPolicyFileButton text-success" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="ri-upload-2-line"></i> Upload File</a></li>
                //         <li><a class="dropdown-item auditInformationButton text-warning" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="mdi mdi-book-search-outline"></i> Audit Info</a></li>
                //         <li><a class="dropdown-item ' . ($data->status == 'Intent' || $data->status == 'Notice of Cancellation' ? 'intentCancelButton' : 'cancelButton') . ' text-danger" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="mdi mdi-book-cancel-outline"></i> Cancel</a></li>

                //     </ul>
                // </div>';


                return $viewButton. '  ' .  '  '. $editButton . ' ' . $dropdown;
            })
            ->rawColumns(['policyStatus', 'action', 'effectiveDate'])
            ->make(true);
        }
    }

    public function getClientActivePolicyList(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $data = $policyDetail->getActivePolicyDetailByLeadId($request['id']);
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
            $statusLabel = $policyStatus;;
            $class = 'bg-secondary';
            switch ($policyStatus) {
                case 'issued':
                case 'Renewal Issued':
                case 'Rewrite':
                case 'Renewal Quoted':
                case 'renewal issued':
                case 'Renewal Payment Processed':
                case 'Reinstate':
                case 'recovered policy issued':
                    $class = 'bg-success';
                    break;

                case 'Cancelled':
                case 'Declined':
                case 'Renewal Declined Payment':
                case 'Renewal Binding Declined':
                case 'Cancellation Request By Customer':
                    $class = 'bg-danger';
                    break;

                case 'Endorsing':
                case 'Notice of Cancellation':
                case 'Renewal Notice of Cancellation':
                case 'Intent':
                case 'Potential For Rewrite':
                case 'Not Interested':
                case 'Process Renewal':
                case 'Renewal Quote':
                case 'Renewal Quoted Assigned':
                case 'Follow Up Renewal':
                case 'Renewal Make A Payment':
                case 'Renewal Request To Bind':
                case 'Rewrite Request To Bind':
                case 'For Rewrite Quotation':
                case 'pending':
                case 'Subject For Rewrite':
                case 'Process Quoted Renewal':
                    $class = 'bg-warning';
                    break;

                case 'old policy':
                    $class = 'bg-secondary';
                    break;
            }
            // $status = now()->isAfter($effectiveDate) ? 'Inactive' : 'Active';
            // $class = now()->isAfter($effectiveDate) ? 'bg-danger' : 'bg-success';
            // Special case for 'Notice of Cancellation'
            if ($policyStatus === 'Notice of Cancellation') {
               $cancellationStatus = CancellationReport::where('policy_details_id', $data->id)->latest()->first();
               $statusLabel = $cancellationStatus->type_of_cancellation ?? $policyStatus;
            }
            return "<span class='badge {$class}'>$statusLabel</span>";
        })
        ->addColumn('effectiveDate', function($data){
            $expirationDate = $data->expiration_date;
            $effectiveDate = $data->effective_date;

            $class = now()->isAfter($expirationDate) || $data->status == 'Dead Policy'  ? 'bg-danger' : 'bg-success';
            return"$effectiveDate - $expirationDate";
        })
        ->addColumn('action', function($data){
            if($data->status == 'Intent' || $data->status == 'Notice of Cancellation'){
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light intentCancelButton" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
            }else{
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
            }
            $viewButton = '<button type="button" class="btn btn-outline-primary btn-sm waves-effect waves-light viewButton" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-eye-line"></i></button>';

            $uploadFileButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light uploadPolicyFileButton" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-upload-2-line"></i></button>';

            $editButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light editButton" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-pencil-line"></i></button>';

            $auditInformationButton = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light auditInformationButton" id="'.$data->id.'"><i class="ri-file-list-3-line"></i></button>';
            // $dropdown = '
            // <div class="dropdown">
            //     <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false">
            //         Actions
            //     </button>
            //     <ul class="dropdown-menu" aria-labelledby="actionMenu">
            //         <li><a class="dropdown-item auditInformationButton text-warning" href="#" id="'.$data->id.'"><i class="mdi mdi-book-search-outline"></i> Audit Info</a></li>
            //         <li><a class="dropdown-item '.($data->status == 'Intent' || $data->status == 'Notice of Cancellation' ? 'intentCancelButton' : 'cancelButton').' text-danger" href="#" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i> Cancel</a></li>
            //     </ul>
            // </div>';
            // return $viewButton. ' ' .  ' '. $editButton . ' ' . $uploadFileButton .  ' '. $auditInformationButton . ' ' . $cancelButton;
            $dropdown = '
            <div class="dropdown" style="display: inline-block;">
                <button class="btn btn-sm dropdown-toggle" type="button" id="actionMenu' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6c757d; color: white; border: none; padding: 5px; font-size: 16px; line-height: 1; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                    &#x2022;&#x2022;&#x2022;
                </button>
                <ul class="dropdown-menu" aria-labelledby="actionMenu' . $data->id . '" style="min-width: 100px;">
                    <li><a class="dropdown-item uploadPolicyFileButton text-success" href="#" id="' . $data->id . '"><i class="ri-upload-2-line"></i> Upload File</a></li>
                    <li><a class="dropdown-item auditInformationButton text-warning" href="#" id="' . $data->id . '"><i class="mdi mdi-book-search-outline"></i> Audit Info</a></li>
                    <li><a class="dropdown-item ' . ($data->status == 'Intent' || $data->status == 'Notice of Cancellation' ? 'intentCancelButton' : 'cancelButton') . ' text-danger" href="#" id="' . $data->id . '"><i class="mdi mdi-book-cancel-outline"></i> Cancel</a></li>
                </ul>
            </div>';



            // $dropdown = '
            // <div class="dropdown">
            //     <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionMenu' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 2px 6px; font-size: 12px;">
            //         Actions
            //     </button>
            //     <ul class="dropdown-menu" aria-labelledby="actionMenu' . $data->id . '" style="max-height: 150px; overflow-y: auto; min-width: 100px;">
            //         <li><a class="dropdown-item viewButton text-primary" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="ri-eye-line"></i> View</a></li>
            //         <li><a class="dropdown-item editButton text-info" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="ri-pencil-line"></i> Edit</a></li>
            //         <li><a class="dropdown-item uploadPolicyFileButton text-success" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="ri-upload-2-line"></i> Upload File</a></li>
            //         <li><a class="dropdown-item auditInformationButton text-warning" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="mdi mdi-book-search-outline"></i> Audit Info</a></li>
            //         <li><a class="dropdown-item ' . ($data->status == 'Intent' || $data->status == 'Notice of Cancellation' ? 'intentCancelButton' : 'cancelButton') . ' text-danger" href="#" id="' . $data->id . '" style="padding: 3px 10px; font-size: 12px;"><i class="mdi mdi-book-cancel-outline"></i> Cancel</a></li>

            //     </ul>
            // </div>';


            return $viewButton. '  ' .  '  '. $editButton . ' ' . $dropdown;
        })
        ->rawColumns(['policyStatus', 'action', 'effectiveDate'])
        ->make(true);
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

    public function changePolicyStatus(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            $policyDetail = PolicyDetail::find($data['id']);
            $policyDetail->status = $data['status'];
            $policyDetail->save();

            DB::commit();
            return response()->json(['success' => 'Success'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}