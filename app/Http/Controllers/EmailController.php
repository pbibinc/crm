<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendFollowUpEmail;
use App\Mail\SendQoute;
use App\Mail\sendTemplatedEmail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\Templates;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //

    public function sendQuotation(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $userProfile = UserProfile::where('user_id', Auth::user()->id)->first();
            $fullName = $userProfile->fullAmericanName();
            $quoteComparison = QuoteComparison::find($id);
            $quotationProduct = QuotationProduct::find($quoteComparison->quotation_product_id);
            if($quoteComparison){
                $qoutedMailData = [
                    'title' => 'Qoutation For ' . $quotationProduct->QuoteInformation->QuoteLead->leads->company_name,
                    'customer_name' => $quotationProduct->QuoteInformation->QuoteLead->leads->GeneralInformation->customerFullName(),
                    'footer' => $fullName,
                    'product' => $quotationProduct->product,
                    'prices' =>$quoteComparison
                ];

                $sendingMail = Mail::to('maechael108@gmail.com')->send(new SendQoute($qoutedMailData));
                if($sendingMail){
                    return response()->json([
                        'success' => true,
                        'message' => 'Email Sent'
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Email Not Sent'
                    ]);
                }
            }
        }
    }

    public function sendFollowUpEmail(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $userProfile = UserProfile::where('user_id', Auth::user()->id)->first();
            $fullName = $userProfile->fullAmericanName();
            $quoteComparison = QuoteComparison::where('quotation_product_id', $id)->first();
            $quotationProduct = QuotationProduct::find($id);
            if($quoteComparison){
                $qoutedMailData = [
                    'title' => 'Qoutation For ' . $quotationProduct->QuoteInformation->QuoteLead->leads->company_name,
                    'customer_name' => $quotationProduct->QuoteInformation->QuoteLead->leads->GeneralInformation->customerFullName(),
                    'footer' => $fullName,
                    'product' => $quotationProduct->product,
                    'prices' =>$quoteComparison
                ];

                $sendingMail = Mail::to('maechael108@gmail.com')->send(new SendFollowUpEmail($qoutedMailData));
                if($sendingMail){
                    return response()->json([
                        'success' => true,
                        'message' => 'Email Sent'
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Email Not Sent'
                    ]);
                }
            }
        }
    }

    public function sendTemplatedEmail(Request $request)
    {
        $subject = 'Test Template Email';
        $template = Templates::find(9);
        $htmlContent = '<h1>Test Template Email</h1>';

        $sendingMail = Mail::to('maechael108@gmail.com')->send(new sendTemplatedEmail($subject, $template->html));
        if($sendingMail){
            return response()->json([
                'success' => true,
                'message' => 'Email Sent'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Email Not Sent'
            ]);
        }
    }

}