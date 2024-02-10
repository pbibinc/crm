<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\PaymentCharged;
use App\Models\PaymentInformation;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Yajra\DataTables\Facades\DataTables;

class PaymentChargedController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $paymentCharged = new PaymentCharged();
            $paymentChargedData = $paymentCharged->get();
            return DataTables::of($paymentChargedData)
            ->addIndexColumn()
            ->addColumn('product_name', function($paymentChargedData){
                $product = $paymentChargedData->paymentInformation->QuoteComparison->QuotationProduct->product;
                return $product;
            })
            ->addColumn('company_name', function($paymentChargedData){
                $lead = $paymentChargedData->paymentInformation->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('payment_method', function($paymentChargedData){
                $paymentMethod = $paymentChargedData->paymentInformation->payment_method;
                return $paymentMethod;
            })
            ->addColumn('amount_to_charged', function($paymentChargedData){
                $amountToCharged = $paymentChargedData->paymentInformation->amount_to_charged;
                return $amountToCharged;
            })
            ->addColumn('compliance', function($paymentChargedData){
                $compliance = $paymentChargedData->paymentInformation->compliance_by;
                return $compliance;
            })
            ->addColumn('payment_type', function($paymentChargedData){
                $type = $paymentChargedData->paymentInformation->payment_type;
                return $type;
            })
            ->addColumn('charged_by', function($paymentChargedData){
                $chargedBy = $paymentChargedData->userProfile->fullName();
                return $chargedBy;
            })
            ->addColumn('action', function($paymentChargedData){
                $editButton = '<a href="#" class="btn btn-sm btn-primary editPaymentButton" data-id="'.$paymentChargedData->id.'"><i class="ri-pencil-line"></i></a>';
                $editFileButton = '<a href="#" class="btn btn-sm btn-outline-info waves-effect waves-light editFilePaymentButton" data-id="'.$paymentChargedData->id.'"><i class="ri-file-edit-line"></i></a>';
                return $editButton . ' '. $editFileButton;
            })
            ->make(true);
        }
        return view('admin.accounting.accounts-for-charged.index');
    }
    //
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $userProfileId = auth()->user()->userProfile->id;
            $file = $request->file('invoiceFile');
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/invoice');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/invoice/'.$basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();

            $paymentCharged = new PaymentCharged();
            $paymentCharged->payment_information_id = $request->paymentInformationId;
            $paymentCharged->user_profile_id = $userProfileId;
            $paymentCharged->invoice_number = $request->invoiceNumber;
            $paymentCharged->charged_date = now();
            $paymentCharged->save();

            $paymentCharged->medias()->attach($metadata->id);

            // $quoteComparison = QuoteComparison::find($request->quoteComparisonId);
            // $quoteComparison->recommended = 10;

            $quoteProduct = QuotationProduct::find($request->quotationProductId);
            $quoteProduct->status = 10;
            $quoteProduct->save();

            $quoteComparison = QuoteComparison::find($request->quoteComparisonId);
            $quoteComparison->recommended = 3;
            $quoteComparison->save();

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function paymentList(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            $paymentInformation = new PaymentInformation();
            $paymentInformationData = $paymentInformation->getPaymentInformationByLeadId($id);
            // dd($paymentInformationData);
            // $paymentInformationData = $paymentInformation->get();
            // $paymentCharged = new PaymentCharged();
            // $paymentChargedData = $paymentCharged->getPaymentCharged($id);
            return DataTables::of($paymentInformationData)
            ->addIndexColumn()
            ->addColumn('payment_type', function($paymentInformationData){
                $paymentType = $paymentInformationData['data']['payment_type'];
                return $paymentType;
            })
            ->addColumn('product', function($paymentInformationData){
                $product = $paymentInformationData['data']->QuoteComparison->QuotationProduct->product;
                return $product;
            })
            ->addColumn('policy_number', function($paymentInformationData){
                $policyNumber = $paymentInformationData['data']->QuoteComparison->quote_no;
                return $policyNumber;
            })
            ->addColumn('invoice_number', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                return $paymentCharged->invoice_number;
            })
            ->addColumn('charged_by', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                return $paymentCharged->userProfile->fullName();
            })
            ->addColumn('charged_date', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                return $paymentCharged->charged_date;
            })
            ->addColumn('action', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                // $media = $paymentCharged->medias;
                // $action = '<a href="'.route('admin.accounting.accounts-for-charged.show', $paymentCharged->id).'" class="btn btn-sm btn-primary">View</a>';
                $viewInvoiceButton = '<button type="button" id="'.$paymentCharged->id.'" class="btn btn-sm btn-success viewInvoiceButton"><i class="ri-file-list-3-line"></i></button>';

                return $viewInvoiceButton;
            })
            ->make(true);
        }
    }

    public function getInvoiceMedia(Request $request)
    {
        $paymentCharged = PaymentCharged::find($request->id);
        $media = $paymentCharged->medias;
        if($media){
            return response()->json(['media' => $media]);
        }
        return null;
    }

    public function edit(Request $request)
    {
        $paymentCharged = PaymentCharged::find($request->id);
        return response()->json(['paymentCharged' => $paymentCharged]);
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $paymentCharged = PaymentCharged::find($request->paymentChargedId);
            $paymentCharged->invoice_number = $request->invoiceNumber;
            $paymentCharged->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice number updated successfully',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function uploadFile(Request $request)
    {
        try{
            $hiddenId = $request->input('hidden_id');
            $file = $request->file('file');

             // $quoteComparison = QuoteComparison::find($hiddenId);
             $basename = $file->getClientOriginalName();
             $directoryPath = public_path('backend/assets/attacedFiles/binding/general-liability-insurance');
             $type = $file->getClientMimeType();
             $size = $file->getSize();
             if(!File::isDirectory($directoryPath)){
                 File::makeDirectory($directoryPath, 0777, true, true);
             }
             $file->move($directoryPath, $basename);
             $filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $basename;

             $metadata = new Metadata();
             $metadata->basename = $basename;
             $metadata->filename = $basename;
             $metadata->filepath = $filepath;
             $metadata->type = $type;
             $metadata->size = $size;
             $metadata->save();

             $metadata->PaymentCharged()->sync($hiddenId);
             return response()->json(['success' => 'File uploaded successfully']);

        }catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }

    }

    public function deleteInvoice(Request $request)
    {
        try{
            $media = Metadata::find($request->input('id'));
            $media->PaymentCharged()->detach($request->input('hidden_id'));
            $media->delete();
        }catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }
    }

    public function exportPaymentList(Request $request)
    {
        try{
            $startDate = $request->startExportDate;
            $endDate = $request->endExportDate;
            $fileName = 'payment-charged'. $startDate . 'to' . $endDate . '.csv';
            $paymentCharged = PaymentCharged::whereBetween('charged_date', [$startDate, $endDate])->get();
            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach($paymentCharged as $data)
            {
                $paymentDataExport = [
                    'Company Name' => $data->paymentInformation->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name,
                    'Product' => $data->paymentInformation->QuoteComparison->QuotationProduct->product,
                    'Payment Method' => $data->paymentInformation->payment_method,
                    'Amount' => $data->paymentInformation->amount_to_charged,
                    'Compliance' => $data->paymentInformation->compliance_by,
                    'Type of Payment' => $data->paymentInformation->payment_type,
                    'Charged By' => $data->userProfile->fullName(),
                ];
                $writer->addRow($paymentDataExport);
            }
            return $writer->toBrowser();
        }catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }

    }
}