<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FinancingAgreement;
use App\Models\FinancingCompany;
use App\Models\FinancingStatus;
use App\Models\Metadata;
use App\Models\PaymentOption;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use App\Models\RecurringAchMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class FinancingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $financeCompany = FinancingCompany::all();
        return view('customer-service.financing.finance-agreement.index', compact('financeCompany'));
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
            $data = $request->all();

            $file = $data['pfaFile'];
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/financing-agreement/');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/financing-agreement/' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;

            $financingAgreement = new FinancingAgreement();
            $financingAgreement->financing_company_id = $data['financingCompany'];
            $financingAgreement->quote_comparison_id = $data['comparisonId'];
            $financingAgreement->is_auto_pay = $data['autoPay'];
            $financingAgreement->due_date = $data['dueDate'];
            $financingAgreement->payment_start = $data['paymentStart'];
            $financingAgreement->monthly_payment = $data['monthlyPayment'];
            $financingAgreement->media_id = $mediaId;
            $financingAgreement->save();

            if($data['autoPay'] == '1'){
                $financingAgreement->is_auto_pay = 1;
                $paymentOption = new PaymentOption();
                $paymentOption->financing_agreement_id = $financingAgreement->id;
                $paymentOption->payment_option = $data['payOption'];
                $paymentOption->save();
            }

            $financialStatus = FinancingStatus::find($data['financialStatusId']);
            $financialStatus->status = 'PFA Created';
            $financialStatus->save();

            $autoPayFile = $data['autoPayFile'];
            $autoPayBasename = $autoPayFile->getClientOriginalName();
            $autoPayDirectoryPath = public_path('backend/assets/attacedFiles/financing-agreement/');
            $autoPayType = $autoPayFile->getClientMimeType();
            $autoPaySize = $autoPayFile->getSize();
            if(!File::isDirectory($autoPayDirectoryPath)){
                File::makeDirectory($autoPayDirectoryPath, 0777, true, true);
            }
            $autoPayFile->move($autoPayDirectoryPath, $autoPayBasename);
            $autoPayFilepath = 'backend/assets/attacedFiles/financing-agreement/' . $autoPayBasename;

            $autoPayMetadata = new Metadata();
            $autoPayMetadata->basename = $autoPayBasename;
            $autoPayMetadata->filename = $autoPayBasename;
            $autoPayMetadata->filepath = $autoPayFilepath;
            $autoPayMetadata->type = $autoPayType;
            $autoPayMetadata->size = $autoPaySize;
            $autoPayMetadata->save();

            $recurringAchMedia = new RecurringAchMedia();
            $recurringAchMedia->financing_aggreement_id = $financingAgreement->id;
            $recurringAchMedia->media_id = $autoPayMetadata->id;
            $recurringAchMedia->save();

            DB::commit();
            return response()->json(['success' => 'Financing Agreement has been saved'], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
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
        $quoteComparison = QuoteComparison::find($id);
        $quoteProduct = $quoteComparison->QuotationProduct;
        $leads = $quoteProduct->QuoteInformation->QuoteLead->leads;
        $financialStatus = FinancingStatus::where('quotation_product_id', $quoteProduct->id)->first();
        return response()->json(['quoteComparison' => $quoteComparison, 'quoteProduct' => $quoteProduct, 'leads' => $leads, 'financialStatus' => $financialStatus], 200);
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
        $financingStatus = FinancingStatus::find($id);
        $financingStatus->status = $request->status;
        $financingStatus->save();
        return response()->json(['success' => 'Status updated successfully.']);
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

    public function productForFinancing(Request $request)
    {
        if($request->ajax())
        {
            $financingStaus = new FinancingStatus();
            $data = $financingStaus->getProductFinancing();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $policyCost = QuoteComparison::where('quotation_product_id', $data->QuotationProduct->id)->where('recommended', 3)->first();
                return $policyCost->quote_no;
            })
            ->addColumn('company_name', function($data){
                $leads = $data->QuotationProduct->QuoteInformation->QuoteLead->leads;
                $company_name = '<a href="" id="'.$data->id.'" name="showPolicyForm" class="procesFinancingRequest">'. $leads->company_name.'</a>';
                return $company_name;
            })
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('full_payment', function($data){
                $policyCost = QuoteComparison::where('quotation_product_id', $data->QuotationProduct->id)->where('recommended', 3)->first();
                return $policyCost->full_payment;
            })
            ->addColumn('effective_date', function($data){
                $policyCost = QuoteComparison::where('quotation_product_id', $data->QuotationProduct->id)->where('recommended', 3)->first();
                return $policyCost->quote_no;
            })
            ->rawColumns(['company_name'])
            ->make(true);
        }
    }

    public function pfaCreation(Request $request)
    {
        if($request->ajax())
        {
            $financingStaus = new FinancingStatus();
            $data = $financingStaus->getPfaProcessing();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $quoteComparison = QuoteComparison::where('quotation_product_id', $data->QuotationProduct->id)->where('recommended', 3)->first();
                $policyNumber = '<a href="" id="'.$quoteComparison->id.'" name="showPolicyForm" class="createPfa">'. $quoteComparison->quote_no.'</a>';
                return $policyNumber;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;

                return $company_name;
            })
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('full_payment', function($data){
                $policyCost = QuoteComparison::where('quotation_product_id', $data->QuotationProduct->id)->where('recommended', 3)->first();
                return $policyCost->full_payment;
            })
            ->addColumn('effective_date', function($data){
                $policyCost = QuoteComparison::where('quotation_product_id', $data->QuotationProduct->id)->where('recommended', 3)->first();
                return $policyCost->quote_no;
            })
            ->rawColumns(['policy_number'])
            ->make(true);

        }
    }

    public function newFinancingAgreement(Request $request)
    {
        $financingAgreement = new FinancingAgreement();
        $data = $financingAgreement->getNewFinancingAgreement();
        $baseUrl = config('app.url');
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('policy_number', function($data){
            $quoteComparison = QuoteComparison::find($data->quote_comparison_id);
            return $quoteComparison->quote_no;
        })
        ->addColumn('financing_company', function($data){
            $financeCompany = FinancingCompany::find($data->financing_company_id);
            return $financeCompany->name;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('product', function($data){
            $product = $data->QuoteComparison->QuotationProduct->product;
            return $product;
        })
        ->addColumn('auto_pay', function($data){
            $paymentOption = PaymentOption::where('financing_agreement_id', $data->id)->first();
            $autoPay = $data->is_auto_pay == 1 ? $paymentOption->payment_option : 'No';
            return $autoPay;
        })
        ->addColumn('media', function($data){
            $media = Metadata::find($data->media_id);
            $baseUrl = "https://insuraprime_crm.test/";
            $fullPath = $baseUrl . $media->filepath;
            return '<a href="'.$fullPath.'" target="_blank">'.$media->basename.'</a>';
        })
        ->rawColumns(['media'])
        ->make(true);
    }
}