<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PricingBreakdown;
use Illuminate\Http\Request;

class PricingBreakdownController extends Controller
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
        $pricingBreakdown = new PricingBreakdown();
        $pricingBreakdown->premium = $request->premium;
        $pricingBreakdown->endorsements = $request->endorsements;
        $pricingBreakdown->policy_fee = $request->policy_fee;
        $pricingBreakdown->inspection_fee = $request->inspection_fee;
        $pricingBreakdown->stamping_fee = $request->stamping_fee;
        $pricingBreakdown->surplus_lines_tax = $request->surplus_lines_tax;
        $pricingBreakdown->placement_fee = $request->placement_fee;
        $pricingBreakdown->broker_fee = $request->broker_fee;
        $pricingBreakdown->miscellaneous_fee = $request->miscellaneous_fee;
        $pricingBreakdown->save();
        return $pricingBreakdown->id;
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