<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FinancingAgreement;
use App\Models\FinancingCompany;
use App\Models\FinancingStatus;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\PaymentOption;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use App\Models\RecurringAchMedia;
use App\Models\SelectedQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
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
            if($request->hasFile('pfaFile')){

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
            }else{
                throw new \Exception('PFA File not found.');
            }

            $financingAgreement = new FinancingAgreement();
            $financingAgreement->financing_company_id = $data['financingCompany'];
            $financingAgreement->selected_quote_id = $data['selectedQuoteId'];
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
            }

            $financialStatus = FinancingStatus::find($data['financialStatusId']);
            $financialStatus->status = 'PFA Created';
            $financialStatus->save();
            DB::commit();
            return response()->json([
             'status' => 'success',
             'message' => 'Payment charged successfully',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json([
             'status' => 'error',
             'message' => $e->getMessage()
            ], 500);
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
    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $selectedQuote = SelectedQuote::find($id);
        $quoteProduct = $selectedQuote->QuotationProduct;
        $leads = $quoteProduct->QuoteInformation->QuoteLead->leads;
        $financialStatus = FinancingStatus::find($data['financingId']);
        return response()->json(['selectedQuote' => $selectedQuote, 'quoteProduct' => $quoteProduct, 'leads' => $leads, 'financialStatus' => $financialStatus], 200);
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
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->quote_no;
            })
            ->addColumn('company_name', function($data){
                $leads = $data->QuotationProduct->QuoteInformation->QuoteLead->leads;
                $company_name = '<a href="" id="'.$leads->id.'" name="showPolicyForm" class="viewButton">'. $leads->company_name.'</a>';
                return $company_name;
            })
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('full_payment', function($data){
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->full_payment;
            })
            ->addColumn('effective_date', function($data){
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->effective_date;
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewNoteButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                $viewButton = '<button class="edit btn btn-outline-info btn-sm " id="'.$leadId.'"><i class="ri-eye-line"></i></button>';
                $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light procesFinancingRequest" id="'.$data->id.'" data-lead-id="'.$leadId.'"><i class=" ri-task-line"></i></button>';
                return  $processButton . ' ' .$viewNoteButton;
            })
            ->rawColumns(['company_name', 'action'])
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
                $selectedQuote = SelectedQuote::find($data->selected_quote_id);
                $policyNumber = '<a href="" id="'.$selectedQuote->id.'" data-financing-id="'.$data->id.'" name="showPolicyForm" class="createPfa">'. $selectedQuote->quote_no.'</a>';
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
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->full_payment;
            })
            ->addColumn('effective_date', function($data){
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->quote_no;
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
            $quoteComparison = SelectedQuote::find($data->selected_quote_id);
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
            $url = env('APP_FORM_LINK');
            $media = Metadata::find($data->media_id);
            $baseUrl = $url;
            $fullPath = $baseUrl . $media->filepath;
            return '<a href="'.$fullPath.'" target="_blank">'.$media->basename.'</a>';
        })
        ->rawColumns(['media'])
        ->make(true);
    }

    public function getCustomersPfa(Request $request)
    {
        try{
            $id = $request->id;
            $financingAgreement = new FinancingAgreement();
            $data = $financingAgreement->getCustomersPfa($id);
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $quoteComparison = SelectedQuote::find($data['data']['selected_quote_id']);
                return $quoteComparison->quote_no ? $quoteComparison->quote_no : 'N/A';
            })
            ->addColumn('financing_company', function($data){
                $financeCompany = FinancingCompany::find($data['data']['financing_company_id']);
                return $financeCompany->name ? $financeCompany->name : 'N/A';
            })
            ->addColumn('company_name', function($data){
                $company_name = Lead::find($data['lead_id'])->company_name;
                return $company_name ? $company_name : 'N/A';
            })
            ->addColumn('product', function($data){
                $product = SelectedQuote::find($data['data']['selected_quote_id'])->QuotationProduct->product;
                return $product;
            })
            ->addColumn('auto_pay', function($data){
                $paymentOption = PaymentOption::where('financing_agreement_id', $data['data']['id'])->first();
                $autoPay = $data['data']['is_auto_pay'] == 1 ? $paymentOption->payment_option : 'No';
                return $autoPay ? $autoPay : 'N/A';
            })
            ->addColumn('media', function($data){
                $baseUrl = url('/');
                $media = Metadata::find($data['data']['media_id']);
                $fullPath = $baseUrl . '/' .$media->filepath;
                return '<a href="'.$fullPath.'" target="_blank">'.$media->basename.'</a>';
            })
            ->rawColumns(['media'])
            ->make(true);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function incompletePfa(Request $request)
    {
        if($request->ajax())
        {
            $financingStaus = new FinancingStatus();
            $data = $financingStaus->incompletePfa();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->quote_no;
            })
            ->addColumn('company_name', function($data){
                $leads = $data->QuotationProduct->QuoteInformation->QuoteLead->leads;
                $company_name = '<a href="" id="'.$data->id.'" name="showPolicyForm" class="procesFinancingRequest">'. $leads->company_name.'</a>';
                return $leads->company_name;
            })
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('full_payment', function($data){
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->full_payment;
            })
            ->addColumn('effective_date', function($data){
                $selectedQuote = SelectedQuote::find($data->selected_quote_id)->first();
                return $selectedQuote->effective_date;
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewNoteButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$leadId.'"><i class="ri-eye-line"></i></button>';
                return $viewButton . ' ' . $viewNoteButton;
            })
            ->rawColumns(['company_name', 'action'])
            ->make(true);
        }
    }
}
