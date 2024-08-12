<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\Templates;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForRewriteQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    public function getForRewriteQuotation(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $userProfileId = auth()->user()->userProfile->id;
        $data = $policyDetail->getForRewritePolicyByStatusAndUserProfileId(['For Rewrite Quotation', 'For Rewrite Quoted'], $userProfileId);
        return DataTables($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('cancelled_date', function($data){
                return Carbon::parse($data->cancellationEndorsement->cancellation_date)->format('M-d-Y');
            })
            ->addColumn('cancelled_by', function($data){
                $userProfile = $data->cancellationEndorsement->UserProfile;
                return $userProfile ? $userProfile->fullAmericanName() : '';
            })
            ->addColumn('cancellation_type', function($data){
                $cancellationEndorsement = $data->cancellationEndorsement;
                return $cancellationEndorsement  ? $cancellationEndorsement->type_of_cancellation : '';
            })
            ->addColumn('policy_status', function($data){
                $policyStatus = $data->status;
                $statusLabel = $policyStatus;;
                $class = 'bg-secondary';
                switch ($policyStatus) {
                    case 'For Rewrite Quotation':
                        $class = 'bg-warning';
                        break;
                    case 'For Rewrite Follow Up':
                        $class = 'bg-info';
                        break;
                    case 'For Rewrite Quoted':
                        $class = 'bg-success';
                        break;
                }
                return "<span class='badge {$class}'>$statusLabel</span>";
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewButton = '<a href="/cancellation/get-for-rewrite-product-lead-view/'.$data->id.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                $sendForQuotationButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light sendForQuotationButton" id="'.$data->id.'"><i class=" ri-clipboard-line"></i></button>';
                return $viewButton . ' ' . $viewNotedButton;
            })
            ->rawColumns(['action', 'policy_status'])
            ->make(true);
    }

    public function rewriteProfileView($policyDetailsId)
    {
        $policyDetail = PolicyDetail::find($policyDetailsId);
        $product = QuotationProduct::find($policyDetail->quotation_product_id);
        if (!$product) {
            Log::warning('Product not found', ['Product ID' => $product->id]);
            return redirect()->route('leads.appointed-leads')->withErrors('Product not found');
        }

        $lead = Lead::find($product->QuoteInformation->QuoteLead->leads->id);
        if (!$lead) {
            Log::warning('Lead not found', ['Product ID' => $product->id]);
            return redirect()->route('leads.appointed-leads')->withErrors('Lead not found');
        }

        $generalInformation = GeneralInformation::find($lead->generalInformation->id);
        if (!$generalInformation) {
            Log::warning('General Information not found', ['Lead ID' => $lead->id]);
            return redirect()->route('leads.appointed-leads')->withErrors('General Information not found');
        }

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

        $carriers = Insurer::all()->sortBy('name');
        $markets = QuoationMarket::all()->sortBy('name');
        $usAddress = UnitedState::getUsAddress($generalInformation->zipcode);
        $timezoneForState = null;
        foreach ($timezones as $timezone => $states) {
            if (in_array($lead->state_abbr, $states)) {
                $timezoneForState = $timezoneStrings[$timezone];
                break;
            }
        }
        $localTime = Carbon::now($timezoneForState ?: 'UTC');

        $generalLiabilities = $generalInformation->generalLiabilities;
        $quationMarket = new QuoationMarket();
        $templates = Templates::all();
        $userProfile = new UserProfile();
        $complianceOfficer = $userProfile->complianceOfficer();
        $products = $product->getQuotedProductByQuotedInformationId($product->quote_information_id);

        return view('leads.appointed_leads.for-rewrite-lead-profile-view.index', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket', 'product', 'templates', 'complianceOfficer', 'carriers', 'markets', 'policyDetail', 'products'));
    }

}