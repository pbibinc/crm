<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\PaymentCharged;
use App\Models\PaymentInformation;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
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
            $paymentChargedData = PaymentCharged::orderBy('charged_date', 'desc')->get();
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
                return $chargedBy ? $chargedBy : 'N/A';
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

            $paymentInformation = PaymentInformation::find($request->paymentInformationId);
            $paymentInformation->status = 'charged';
            $paymentInformation->save();

            if($request->hiddenPaymentType == 'Direct Renewals'){
                $policyDetails = PolicyDetail::where('quotation_product_id', $request->quotationProductId)->where('status', 'Renewal Make A Payment')->first();
                $policyDetails->status = 'Renewal Payment Processed';
                $policyDetails->save();
            }

            $paymentCharged = new PaymentCharged();
            $paymentCharged->payment_information_id = $request->paymentInformationId;
            $paymentCharged->user_profile_id = $userProfileId;
            $paymentCharged->invoice_number = $request->invoiceNumber;
            $paymentCharged->charged_date = now();
            $paymentCharged->save();
            $paymentCharged->medias()->attach($metadata->id);

            $quoteProduct = QuotationProduct::find($request->quotationProductId);
            $quoteProduct->status = 10;
            $quoteProduct->save();

            // $quoteComparison = QuoteComparison::find($request->quoteComparisonId);
            // $quoteComparison->recommended = 3;
            // $quoteComparison->save();

            $selectedQuote = SelectedQuote::find($request->quoteComparisonId);
            $selectedQuote->recommended = 3;
            $selectedQuote->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Payment charged successfully',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();

            $paymentCharged = PaymentCharged::find($id);

            $paymentCharged->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }
    }

    public function paymentList(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            $paymentInformation = new PaymentInformation();
            $paymentInformationData = $paymentInformation->getPaymentInformationByLeadId($id);
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
                return $paymentCharged ? $paymentCharged->invoice_number : 'N/A';
            })
            ->addColumn('charged_by', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                return $paymentCharged ? $paymentCharged->userProfile->fullName() : 'N/A';
            })
            ->addColumn('charged_date', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                return $paymentCharged ? $paymentCharged->charged_date : 'N/A';
            })
            ->addColumn('payment-information_status', function($paymentInformationData){
                $status = $paymentInformationData['data']->status;
                $statusLabel = '';
                $class = '';
                Switch ($status) {
                    case 'pending':
                        $statusLabel ='Pending';
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
                        $statusLabel = 'Unknown';
                        $class = 'bg-secondary';
                        break;
                }
                return "<span class='badge {$class}'>{$statusLabel}</span>";
            })
            ->addColumn('action', function($paymentInformationData){
                $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->first();
                // $media = $paymentCharged->medias;
                // $action = '<a href="'.route('admin.accounting.accounts-for-charged.show', $paymentCharged->id).'" class="btn btn-sm btn-primary">View</a>';

                if($paymentCharged){
                    $viewInvoiceButton = '<button type="button" id="'.$paymentCharged->id.'" class="btn btn-sm btn-success viewInvoiceButton"><i class="ri-file-list-3-line"></i></button>';
                    $editPaymentInformationButton = '<button type="button" id="'.$paymentInformationData['data']->id.'" class="btn btn-info btn-sm waves-effect waves-light editChargedPaymentInformation" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-pencil-line"></i></button>';
                    $dropdown = '<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6c757d; color: white; border: none; padding: 5px; font-size: 16px; line-height: 1; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="ri-more-line"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item viewInvoiceButton" id="' . $paymentCharged->id . '"><i class="ri-upload-2-line"></i> View Invoice File</button></li>
                        <li><button class="dropdown-item deletePaymentInformation" id="' . $paymentInformationData['data']->id . '"><i class="ri-delete-bin-line"></i> Delete</button></li>
                    </ul>
                 </div>';
                    return  $editPaymentInformationButton . ' ' . $dropdown;
                }else{
                    $dropdown = '<div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6c757d; color: white; border: none; padding: 5px; font-size: 16px; line-height: 1; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="ri-more-line"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item deletePaymentInformation" id="' . $paymentInformationData['data']->id . '"><i class="ri-delete-bin-line"></i> Delete</button></li>
                    </ul>
                 </div>';
                    $editPaymentInformationButton = '<button type="button" id="'.$paymentInformationData['data']->id.'" class="btn btn-info btn-sm waves-effect waves-light editPaymentInformationButton" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-pencil-line"></i></button>';
                    return $editPaymentInformationButton . ' ' . $dropdown;
                }
            })
            ->rawColumns(['payment-information_status', 'action'])
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
