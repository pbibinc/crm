<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MarketProduct;
use App\Models\QuoationMarket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MarketListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){
            $data = QuoationMarket::all();
            return DataTables::of($data)
            ->addColumn('action_button', function($data){
                $editButton = '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$data->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';
                $deleteButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm btnDelete" data-id="'.$data->id.'" name="delete"  type="button " ><i class="mdi mdi-trash-can-outline"></i></button>';
                return $editButton . ' ' . $deleteButton;
            })
            ->addColumn('products', function($data){
                $marketProducts = MarketProduct::where('market_id', $data->id)->get();
                $productHtml = '';
                $count = 0;
                foreach($marketProducts as $product){
                    $productHtml .= '<span class="badge bg-primary">' . $product->name . '</span> ';
                    $count++;

                    if ($count % 3 == 0) {
                        $productHtml .= '<br>';
                    }
                }
                return $productHtml;
            })
            ->rawColumns(['action_button', 'products'])
            ->toJson();
        }
        return view('market.index');
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
        $data = $request->all();
        $quotationMarket = new QuoationMarket();
        $quotationMarket->name = $data['name'];
        $quotationMarket->save();
        foreach($data['products'] as $product){
            $marketProduct = new MarketProduct();
            $marketProduct->market_id = $quotationMarket->id;
            $marketProduct->name = $product;
            $marketProduct->save();
        }

        return response()->json(['success' => 'market has been saved'], 200);
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
        $market = QuoationMarket::find($id);
        $marketProduct = $market->products;
        return response()->json(['data' => $market, 'products' => $marketProduct], 200);
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
        //update market
        $data = $request->all();
        $quotationMarket = QuoationMarket::find($id);
        $quotationMarket->name = $data['name'];
        $quotationMarket->save();

        $marketProducts = MarketProduct::where('market_id', $id)->pluck('name')->toArray();

        if($marketProducts != $data['products']){
            MarketProduct::where('market_id', $id)->delete();
            foreach($data['products'] as $product){
                $marketProductModel = new MarketProduct();
                $marketProductModel->market_id = $quotationMarket->id;
                $marketProductModel->name = $product;
                $marketProductModel->save();
            }
        }

        return response()->json(['success' => 'website has been updated'], 200);
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
        $quotationMarket = QuoationMarket::find($id);
        $quotationMarket->delete();
        return response()->json(['success' => 'website has been deleted'], 200);
    }
}
