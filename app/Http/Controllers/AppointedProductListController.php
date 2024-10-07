<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\QuoteLead;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\QuotationProduct;
use App\Http\Controllers\Controller;

class AppointedProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userProfile = new UserProfile();
        $apptaker = $userProfile->apptaker();
        $quoters = $userProfile->qouter();
        $userProfiles = $userProfile->userProfiles();

        $qoutingCount = QuotationProduct::quotingProduct()->count();
        $lead = new Lead();
        $quoteLead = new QuoteLead();
        $appointedLeads = $lead->getAppointedLeads();
        $appointedProducts =  $quoteLead->getAppointedProductByLeads($appointedLeads);
        $appointedLeadCount = $appointedLeads->count();
        $quotationProduct = new QuotationProduct();
        // $appointedProducts = $quotationProduct->appointedProduct();
        $groupedProducts = collect($appointedProducts)->groupBy('company')->toArray();

        // if($request->ajax())
        // {
        //     $leads = new Lead();
        //     $appointedLeads = $leads->getAppointedLeads();
        //     $appointedLeadsIds = $appointedLeads->pluck('id');
        //     $generalInformationIds = [];
        //     $products = [];
        //     foreach($appointedLeadsIds as $appointedLeadsId)
        //     {
        //         $generalInformationId = GeneralInformation::getIdByLeadId($appointedLeadsId);
        //         if($generalInformationId !== null){
        //             array_push($generalInformationIds, $generalInformationId);
        //         }
        //     }
        //     if($generalInformationIds !== null){
        //         foreach($generalInformationIds as $generalInformationId){
        //             $product = GeneralInformation::getProductByGeneralInformationId($generalInformationId);
        //             array_push($products, $product);
        //         }
        //     }
        //     $index = 0;
        //     return DataTables::of($appointedLeads)
        //            ->addIndexColumn()
        //            ->addColumn('products', function($row) use (&$products, &$index){
        //             $productGroups = array_chunk($products[$index++], 3);
        //             $containers = [];

        //             foreach ($productGroups as $group) {
        //                 $spans = array_map(function($product) {
        //                     return "<span class='badge bg-info permission-badge'><h6>{$product}</h6></span>";
        //                 }, $group);
        //                 $containers[] = '<div>' . implode(' ', $spans) . '</div>';
        //             }
        //             return '<div class="product-column">'. implode('', $containers) . '</div>';
        //            })
        //            ->addColumn('current_user', function($appointedLeads){
        //                   $userProfile = $appointedLeads->userProfile->first();
        //                   $currentUserName = $userProfile ? $userProfile->fullAmericanName(): 'N/A';
        //                   return $currentUserName;
        //              })
        //            ->addColumn('checkbox', function($appointedLeads) {
        //                 $userProfile = $appointedLeads->userProfile->first();
        //                 $currentUserId = $userProfile ? $userProfile->id : null;
        //                 $value = $appointedLeads->id . '_' . $currentUserId ;
        //                 return '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="' . $value . '" />';
        //             })
        //            ->rawColumns(['products', 'checkbox'])
        //            ->make(true);
        // }
        return view('leads.appointed-products.index', compact('quoters', 'userProfiles', 'appointedLeadCount', 'qoutingCount', 'groupedProducts', 'appointedProducts'));

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
}
