<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\PaymentInformation;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use App\Models\Templates;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RenewalPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userProfile = new UserProfile();
        $userProfiles = UserProfile::orderBy('firstname')->get();
        $complianceOfficer = $userProfile->complianceOfficer();

        return view('customer-service.renewal.renewal-policy.index', compact('userProfiles', 'complianceOfficer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function policyForRenewalList(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $policiesData =  PolicyDetail::query()->where('status', 'Renewal Quoted Assigned')->with(['quotedRenewalUserprofile']);
        if($request->ajax()){
            if($request->has('userProfileDropdown') && $request->userProfileDropdown != ''){
                $filter = $request->userProfileDropdown;
                $policiesData->whereHas('quotedRenewalUserprofile', function($query) use ($filter){
                   $query->where('user_profile_id', $filter);
                });
            }
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                $productId =  $policiesData->quotation_product_id;
                return '<a href=""  id="'.$policiesData->id.'" class="renewalPolicyButton">'.$policyNumber.'</a>';
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = SelectedQuote::where('quotation_product_id', $policiesData->quotation_product_id)->first();
                return $quote ? $quote->full_payment : 'N/A';
            })
            ->addColumn('assignedTo', function($policiesData){
                $quotedRenewalUserProfile = $policiesData->quotedRenewalUserprofile()->first();
                return $quotedRenewalUserProfile ? $quotedRenewalUserProfile->fullAmericanName() : 'N/A';
            })
            ->rawColumns(['company_name', 'policy_no'])
            ->make(true);
        }
    }

    public function processQuotedPolicyRenewal(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $policiesData = PolicyDetail::query()->where('status', 'Process Quoted Renewal')->with(['quotedRenewalUserprofile']);
        if($request->ajax()){
            if($request->has('userProfileDropdown') && $request->userProfileDropdown != ''){
                $filter = $request->userProfileDropdown;
                $policiesData->whereHas('quotedRenewalUserprofile', function($query) use ($filter){
                   $query->where('user_profile_id', $filter);
                });
            }
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                $productId = $policiesData->quotation_product_id;
                return '<a href="/customer-service/get-renewal-policy-view/'.$policiesData->id.'"  id="'.$policiesData->id.'">'.$policyNumber.'</a>';
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = SelectedQuote::where('quotation_product_id', $policiesData->quotation_product_id)->first();
                return $quote ? $quote->full_payment : 'N/A';
            })
            ->addColumn('assignedTo', function($policiesData){
                $quotedRenewalUserProfile = $policiesData->quotedRenewalUserprofile()->first();
                return $quotedRenewalUserProfile ? $quotedRenewalUserProfile->fullAmericanName() : 'N/A';
            })
            ->rawColumns(['company_name', 'policy_no'])
            ->make(true);
        }
    }

    public function renewalPolicyView($id)
    {
        $policyDetail = PolicyDetail::find($id);
        $product = QuotationProduct::find($policyDetail->quotation_product_id);
        $products = QuotationProduct::where('quote_information_id', $product->quote_information_id)->get();
        $lead = Lead::find($product->QuoteInformation->QuoteLead->leads->id);
        $generalInformation = GeneralInformation::find($lead->generalInformation->id);
        $userProfile = new UserProfile();
        $complianceOfficer = $userProfile->complianceOfficer();
        $timezones = [
            'Eastern' => ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV'],
            'Central' => ['AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI'],
            'Mountain' => ['AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY'],
            'Pacific' => ['CA', 'OR', 'WA'],
            'Alaska' => ['AK'],
            'Hawaii-Aleutian' => ['HI']
        ];
        $timezoneStrings = [
            'Eastern' => 'America/New_York',
            'Central' => 'America/Chicago',
            'Mountain' => 'America/Denver',
            'Pacific' => 'America/Los_Angeles',
            'Alaska' => 'America/Anchorage',
            'Hawaii-Aleutian' => 'Pacific/Honolulu'
        ];
        $timezoneForState = null;
        $quationMarket = new QuoationMarket();
        $templates = Templates::all();
        if(!$lead || !$generalInformation){
            return redirect()->route('leads.appointed-leads')->withErrors('No DATA found');
            // dd($lead, $generalInformation );
        }
        $usAddress = UnitedState::getUsAddress($generalInformation->zipcode);
        foreach($timezones as $timezone => $states){
            if(in_array($lead->state_abbr, $states)){
                $timezoneForState =  $timezoneStrings[$timezone];
            }
        }
        $localTime = Carbon::now($timezoneForState);
        $generalLiabilities = $generalInformation->generalLiabilities;
        $markets = QuoationMarket::all()->sortBy('name');
        $carriers = Insurer::all()->sortBy('name');
        $productIds = $lead->getQuotationProducts()->pluck('id')->toArray();
        $selectedQuotes = SelectedQuote::whereIn('quotation_product_id', $productIds)->get() ?? [];
        return view('leads.appointed_leads.renewal-quoted-policy-view.index', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket', 'product', 'templates', 'complianceOfficer', 'markets', 'carriers', 'policyDetail', 'products', 'productIds', 'selectedQuotes'));
    }

    public function renewalMakePaymentList(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $statuses = [
            'Renewal Make A Payment',
            'Renewal Declined Payment',
            'Renewal Payment Processed'
        ];
        $policiesData = PolicyDetail::query()->whereIn('status', $statuses)->with(['quotedRenewalUserprofile']);
        if($request->ajax()){
            if($request->has('userProfileDropdown') && $request->userProfileDropdown != ''){
                $filter = $request->userProfileDropdown;
                $policiesData->whereHas('quotedRenewalUserprofile', function($query) use ($filter){
                   $query->where('user_profile_id', $filter);
                });
            }
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('current_policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                $productId = $policiesData->quotation_product_id;
                $product = QuotationProduct::find($productId);
                $selectedQuote = SelectedQuote::find($product->selected_quote_id);
                // return '<a href="/customer-service/get-renewal-policy-view/'.$policiesData->id.'"  id="'.$policiesData->id.'">'.$selectedQuote->quote_no.'</a>';
                return $selectedQuote->quote_no;
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = SelectedQuote::where('quotation_product_id', $policiesData->quotation_product_id)->first();
                return $quote ? $quote->full_payment : 'N/A';
            })
            ->addColumn('current_policy_cost', function($policiesData){
                $productId = $policiesData->quotation_product_id;
                $product = QuotationProduct::find($productId);
                $selectedQuote = SelectedQuote::find($product->selected_quote_id);
                return $selectedQuote ? $selectedQuote->full_payment : 'N/A';
            })
            ->addColumn('assignedTo', function($policiesData){
                $quotedRenewalUserProfile = $policiesData->quotedRenewalUserprofile()->first();
                return $quotedRenewalUserProfile ? $quotedRenewalUserProfile->fullAmericanName() : 'N/A';
            })
            ->addColumn('paymentStatus', function($policiesData){
                $productId = $policiesData->quotation_product_id;
                $product = QuotationProduct::find($productId);
                $selectedQuote = SelectedQuote::find($product->selected_quote_id);

                $paymentStatus = PaymentInformation::where('selected_quote_id', $selectedQuote->id)->first();
                $paymentStatusData = $paymentStatus ? $paymentStatus->status : 'N/A';
                $statusLabel = '';
                $class = '';
                Switch ($paymentStatus->status){
                    case 'pending':
                        $statusLabel = 'Pending';
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
                        $statusLabel = 'N/A';
                        $class = 'bg-secondary';
                        break;
                }
                return "<span class='badge {$class}'>{$statusLabel}</span>";
            })
            ->addColumn('action', function($policiesData){
                $paymentInformation = PaymentInformation::where('selected_quote_id', QuotationProduct::find($policiesData->quotation_product_id)->selected_quote_id)->first();
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                $resendButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light resendButton" id="'.$paymentInformation->id.'" data-policy-id="'.$policiesData->id.'"><i class="  ri-repeat-2-line"></i></button>';
                $viewProfileButton = '<a href="'.route('get-renewal-policy-view', ['productId' => $policiesData->id]).'" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i></a>';
                $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$policiesData->quotation_product_id.'"><i class=" ri-task-line"></i></button>';
                $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'. $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNoteButton" id="'.$lead->id.'"><i class="ri-message-2-line"></i></button>';
                // $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
                if($paymentInformation->status == 'declined'){
                    return $viewProfileButton . ' ' . $viewNotedButton . ' ' . $resendButton;
                }elseif($paymentInformation->status == 'pending'){
                    return $viewProfileButton . ' ' . $viewNotedButton;
                }elseif($paymentInformation->status == 'charged'){
                    return $viewProfileButton . ' ' . $viewNotedButton . ' ' . $processButton;
                }

            })
            ->rawColumns(['company_name', 'current_policy_no', 'paymentStatus', 'action'])
            ->make(true);
        }
    }

    public function renewalRequestToBind(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $statuses = [
            'Renewal Request To Bind'
        ];

        $policiesData = PolicyDetail::query()->whereIn('status', $statuses)->with(['quotedRenewalUserprofile']);
        if($request->ajax()){
            if($request->has('userProfileDropdown') && $request->userProfileDropdown != ''){
                $filter = $request->userProfileDropdown;
                $policiesData->whereHas('quotedRenewalUserprofile', function($query) use ($filter){
                   $query->where('user_profile_id', $filter);
                });
            }
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                $productId = $policiesData->quotation_product_id;
                $product = QuotationProduct::find($productId);
                $selectedQuote = SelectedQuote::find($product->selected_quote_id);
                return '<a href="/customer-service/get-renewal-policy-view/'.$policiesData->id.'"  id="'.$policiesData->id.'">'.$selectedQuote->quote_no.'</a>';
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = SelectedQuote::where('quotation_product_id', $policiesData->quotation_product_id)->first();
                return $quote ? $quote->full_payment : 'N/A';
            })
            ->addColumn('assignedTo', function($policiesData){
                $quotedRenewalUserProfile = $policiesData->quotedRenewalUserprofile()->first();
                return $quotedRenewalUserProfile ? $quotedRenewalUserProfile->fullAmericanName() : 'N/A';
            })
            ->addColumn('bindingStatus', function($policiesData){
                $productStatus = $policiesData->QuotationProduct->status;
                $statusLabel = '';
                $class = '';
                switch ($productStatus) {
                    case 17:
                        $statusLabel = 'Pending';
                        $class = 'bg-warning';
                    break;
                    case 18:
                        $statusLabel = 'Renewal Resend RTB';
                        $class = 'bg-warning';
                    break;
                    case 20:
                        $statusLabel = 'Bound';
                        $class = 'bg-success';
                    break;
                    case 19:
                        $statusLabel = 'Binding';
                        $class = 'bg-warning';
                    break;
                    case 23:
                        $statusLabel = 'Declined';
                        $class = 'bg-danger';
                    break;
                    case 14:
                        $statusLabel = 'Declined';
                        $class = 'bg-danger';
                    break;
                    default:
                        $statusLabel = $productStatus;
                        $class = 'bg-secondary';
                }
                return "<span class='badge {$class}'>{$statusLabel}</span>";
            })
            ->rawColumns(['company_name', 'policy_no', 'bindingStatus'])
            ->make(true);
        }
    }

    public function newRenewedPolicy(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $statuses = [
            'renewal issued'
        ];
        $policiesData = PolicyDetail::query()->whereIn('status', $statuses)->with(['quotedRenewalUserprofile'])->where('created_at' , '>=', Carbon::now()->subDays(30));

        if($request->ajax()){
            if($request->has('userProfileDropdown') && $request->userProfileDropdown != ''){
                $filter = $request->userProfileDropdown;
                $policiesData->whereHas('quotedRenewalUserprofile', function($query) use ($filter){
                   $query->where('user_profile_id', $filter);
                });
            }
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                $productId = $policiesData->quotation_product_id;
                return '<a href="/customer-service/get-renewal-policy-view/'.$productId.'"  id="'.$policiesData->id.'">'.$policyNumber.'</a>';
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('assignedTo', function($policiesData){
                $quotedRenewalUserProfile = $policiesData->quotedRenewalUserprofile()->first();
                return $quotedRenewalUserProfile ? $quotedRenewalUserProfile->fullAmericanName() : 'N/A';
            })
            ->rawColumns(['company_name', 'policy_no'])
            ->make(true);
        }

    }
}