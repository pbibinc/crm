<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use App\Models\RenewalQuote;
use App\Models\SelectedQuote;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Svg\Tag\Rect;

class RenewalQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $policiesData = $userProfileData->renewalPolicy()->where('status', 'Process Renewal')->get();
        if($request->ajax()){
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                return '<a href="" class="renewalReminder" id="'.$policiesData->policy_details_id.'">'.$policyNumber.'</a>';
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = QuoteComparison::where('quotation_product_id', $policiesData->quotation_product_id)->where('recommended', 3)->first();
                return $quote->full_payment;
            })
            ->rawColumns(['company_name', 'policy_no'])
            ->make(true);
        }
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
        try{
            DB::beginTransaction();
            $renewalQuotation = RenewalQuote::firstOrNew(['quote_comparison_id' => $request->id]);
            $renewalQuotation->status = 'Pending';
            $renewalQuotation->save();
            DB::commit();
            return response()->json(['message' => 'Renewal Quote Created Successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

    public function editRenewalQuote(Request $request)
    {
        try{
            DB::beginTransaction();
            // Retrieve the model instance
            $renewalQuotation = RenewalQuote::where('quote_comparison_id', $request->id)->first();

            if ($renewalQuotation) {
                // Update the status
                $renewalQuotation->status = 'Old Quote';
                $renewalQuotation->save();
            } else {
                return response()->json(['error' => 'Renewal quotation not found.'], 404);
            }
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getForQuoteRenewal(Request $request)
    {
        try{
            $policyDetails = new PolicyDetail();
            $policiesData = $policyDetails->getPolicyForRenewal()->where('status', 'Renewal Quote');
            // dd($policiesData);
            if($request->ajax()){
                $dataTable =  DataTables($policiesData)
                ->addIndexColumn()
                ->addColumn('policy_no', function($policiesData){
                    $policyNumber = $policiesData->policy_number;
                    $productId =  $policiesData->quotation_product_id;
                    $button = '<a href="/customer-service/renewal/get-renewal-lead-view/'.$policiesData->id.'"  id="'.$policiesData->policy_details_id.'">'.$policyNumber.'</a>';
                    return $policyNumber;
                })
                ->addColumn('company_name', function($policiesData){
                    $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                    return $lead->company_name;
                })
                ->addColumn('product', function($policiesData){
                    return $policiesData->QuotationProduct->product;
                })
                ->addColumn('previous_policy_price', function($policiesData){
                    $quote = SelectedQuote::find($policiesData->selected_quote_id)->first();
                    return $quote ? $quote->full_payment : 'N/A';
                })
                ->addColumn('action', function($policiesData){
                    $viewButton = '<a href="/customer-service/renewal/get-renewal-lead-view/'.$policiesData->id.'" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i></a>';
                    return $viewButton;
                })
                ->rawColumns(['company_name', 'policy_no', 'action'])
                ->make(true);
                return $dataTable;
            }
        }catch(\Exception $e){
            Log::info('Error in getForQuoteRenewal function', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function getQuotedRenewal(Request $request)
    {
        try{
            $policyDetails = new PolicyDetail();
            $policiesData = $policyDetails->getPolicyForRenewal()->where('status', 'Renewal Quoted');
            if($request->ajax()){
                $dataTable = DataTables($policiesData)
                ->addIndexColumn()
                ->addColumn('policy_no', function($policiesData){
                    $policyNumber = $policiesData->policy_number;
                    $productId =  $policiesData->quotation_product_id;
                    return '<a href="/customer-service/renewal/get-renewal-lead-view/'.$policiesData->id.'"  id="'.$policiesData->policy_details_id.'">'.$policyNumber.'</a>';
                })
                ->addColumn('company_name', function($policiesData){
                    $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                    return $lead->company_name;
                })
                ->addColumn('product', function($policiesData){
                    return $policiesData->QuotationProduct->product;
                })
                ->addColumn('previous_policy_price', function($policiesData){
                    $quote = SelectedQuote::find($policiesData->selected_quote_id)->first();
                    return $quote ? $quote->full_payment : 'N/A';
                })
                ->rawColumns(['company_name', 'policy_no'])
                ->make(true);
                return $dataTable;
            }
        }catch(\Exception $e){
            Log::info('Error in getForQuoteRenewal function', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function renewalHandledPolicy(Request $request)
    {
        try{
            $policyDetails = new PolicyDetail();
            $statusesToExclude = ['issued', 'Process Renewal', 'Renewal Quote', 'Renewal Quoted'];
            $policiesData = $policyDetails->getPolicyForRenewal()->whereNotIn('status', $statusesToExclude);
            if($request->ajax()){
                $dataTable =  DataTables($policiesData)
                ->addIndexColumn()
                ->addColumn('policy_no', function($policiesData){
                    $policyNumber = $policiesData->policy_number;
                    $productId =  $policiesData->quotation_product_id;
                    return '<a href="/customer-service/renewal/get-renewal-lead-view/'.$policiesData->id.'"  id="'.$policiesData->policy_details_id.'">'.$policyNumber.'</a>';
                })
                ->addColumn('company_name', function($policiesData){
                    $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                    return $lead->company_name;
                })
                ->addColumn('product', function($policiesData){
                    return $policiesData->QuotationProduct->product;
                })
                ->addColumn('status', function($policiesData){
                    return $policiesData->status;
                })
                ->addColumn('handledBy', function($policiesData){
                    $userProfile = $policiesData->quotedRenewalUserprofile()->first();
                    return $userProfile ? $userProfile->fullAmericanName() : 'N/A';
                })
                ->rawColumns(['company_name', 'policy_no'])
                ->make(true);
                return $dataTable;
            }
        }catch(\Exception $e){
            Log::info('Error in renewalHandledPolicy function', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}