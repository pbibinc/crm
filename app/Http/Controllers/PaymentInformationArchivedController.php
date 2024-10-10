<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentCharged;
use App\Models\PaymentInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentInformationArchivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.accounting.payment-archive.index');
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

        return view('admin.accounting.payment-archive.index', compact('id'));
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

    public function restore(Request $request)
    {
        try{
            DB::beginTransaction();
            $paymentInformation = PaymentInformation::withTrashed()->find($request->id);
            $paymentInformation->restore();
            $paymentCharged = PaymentCharged::where('payment_information_id', $request->id)->withTrashed()->first();
            if($paymentCharged){
                $paymentCharged->restore();
            }
            DB::commit();
            return response()->json(['success' => 'Payment Information has been restored successfully!']);
        }catch(\Exception $e){
             DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPaymentArchivedList(Request $request)
    {
        $paymentInformation = new PaymentInformation();
        $paymentInformationData = $paymentInformation->getTrashedPaymentInformationByLeadId($request->id);
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
            $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->withTrashed()->first();
            return $paymentCharged ? $paymentCharged->invoice_number : 'N/A';
        })
        ->addColumn('charged_by', function($paymentInformationData){
            $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->withTrashed()->first();
            return $paymentCharged ? $paymentCharged->userProfile->fullName() : 'N/A';
        })
        ->addColumn('charged_date', function($paymentInformationData){
            $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->withTrashed()->first();
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
            $paymentCharged = PaymentCharged::where('payment_information_id', $paymentInformationData['data']->id)->withTrashed()->first();
            // $media = $paymentCharged->medias;
            // $action = '<a href="'.route('admin.accounting.accounts-for-charged.show', $paymentCharged->id).'" class="btn btn-sm btn-primary">View</a>';
            $restore = '<button class="btn btn-outline-primary waves-effect waves-light btn-sm restorePaymentInformation"  id="'.$paymentInformationData['data']->id.'" name="restore" type="button "><i class="mdi mdi-backup-restore"></i></button>';
            return $restore;
        })
        ->rawColumns(['payment-information_status', 'action'])
        ->make(true);

    }




}