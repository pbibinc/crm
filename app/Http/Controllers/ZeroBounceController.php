<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\ZeroBounce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ZeroBounceController extends Controller
{
    public function singleEmailValidatorIndex() {
        return view("email-tools.zerobounce.single-email-validator.index");
    }

    public function batchEmailValidatorIndex() {
        return view("email-tools.zerobounce.batch-email-validator.index");
    }

    public function countRemainingBalance() {
        try {
            $url = "https://api.zerobounce.net/v2/getcredits?api_key=" . env("ZEROBOUNCE_API_KEY");
            $response = Http::get($url);
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Credits'])) {
                    return response()->json([
                        'status' => 'success',
                        'credits' => $data['Credits']
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Balance information is missing from the API response.'
                    ], 500);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to retrieve balance from ZeroBounce API.'
                ], 500);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function singleEmailValidatorCheck(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'emailAddress' => 'required|email'
                ]);

                $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"];
                $url = "https://api.zerobounce.net/v2/validate?api_key=" . env("ZEROBOUNCE_API_KEY") . "&email={$validatedData['emailAddress']}&ip_address={$ipAddress}";

                $response = Http::get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    // Mapping statuses to explanations
                    $status = $data['status'];
                    $subStatus = $data['sub_status'];
                    $explanation = '';

                    // Status explanations
                    $statusCodes = [
                        'valid' => 'These emails are determined to be valid and safe to email.',
                        'invalid' => 'These emails are determined to be invalid, please delete them from your mailing list.',
                        'catch-all' => 'These emails are impossible to validate without sending a real email.',
                        'spamtrap' => 'These emails are believed to be spamtraps and should not be mailed.',
                        'abuse' => 'These emails are from people known to click abuse links in emails.',
                        'do_not_mail' => 'These emails are valid, but should not be mailed under normal circumstances.',
                        'unknown' => 'These emails could not be validated at this time.',
                    ];

                    // Sub-status explanations
                    $subStatusExplanations = [
                        'alias_address' => 'These emails act as forwarders/aliases and are not real inboxes.',
                        'antispam_system' => 'These emails have anti-spam systems deployed, preventing validation.',
                        'does_not_accept_mail' => 'These domains only send mail and don’t accept it.',
                        'exception_occurred' => 'An exception occurred while validating the email.',
                        'failed_smtp_connection' => 'These emails belong to a mail server that failed SMTP connection.',
                        'failed_syntax_check' => 'These emails failed RFC syntax check.',
                        'forcible_disconnect' => 'The mail server disconnected immediately upon connection.',
                        'global_suppression' => 'These emails are in global suppression lists and should not be mailed.',
                        'greylisted' => 'The mail server temporarily denied validation; retry later.',
                        'leading_period_removed' => 'A period was removed from the start of the email address for compatibility.',
                        'mail_server_did_not_respond' => 'The mail server did not respond to validation attempts.',
                        'mail_server_temporary_error' => 'A temporary mail server error occurred.',
                        'mailbox_quota_exceeded' => 'The recipient’s mailbox is full, and the email could not be delivered.',
                        'mailbox_not_found' => 'The email address does not exist.',
                        'no_dns_entries' => 'The domain has no DNS entries.',
                        'possible_trap' => 'The email contains keywords that might indicate a spam trap.',
                        'possible_typo' => 'The email seems to be a typo of a popular domain.',
                        'role_based' => 'This is a role-based email, typically used by groups of people.',
                        'role_based_catch_all' => 'This is a role-based email in a catch-all domain.',
                        'timeout_exceeded' => 'The mail server is responding too slowly to validate the email.',
                        'unroutable_ip_address' => 'The email domain points to an unroutable IP address.',
                        'disposable' => 'This is a temporary, disposable email address.',
                        'toxic' => 'This email address is known to be toxic (abuse, spam, or bot-created).',
                        'alternate' => 'This is a valid alternate email address, often used as a secondary address.'
                    ];

                    // Explanation based on status or sub-status
                    if (isset($subStatusExplanations[$subStatus])) {
                        $explanation = $subStatusExplanations[$subStatus];
                    } elseif (isset($statusCodes[$status])) {
                        $explanation = $statusCodes[$status];
                    } else {
                        $explanation = 'Email validation completed but no specific explanation was found.';
                    }

                    return response()->json([
                        'status' => 'success',
                        'data' => [
                            'status' => $status,
                            'sub_status' => $subStatus,
                            'explanation' => $explanation
                        ]
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to validate email address using ZeroBounce API.'
                    ]);
                }
            } else {
                throw new \Exception('Method not allowed.');
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function batchEmailValidatorCheck(Request $request){
        try {
            if ($request->isMethod('post')) {
                // Get the input data from the request
                $emailData = $request->json()->all();

                // Extract the email_batch from the request
                $emailBatch = $emailData['email_batch'] ?? [];

                if (empty($emailBatch)) {
                    throw new Exception('No emails provided.');
                }

                // Prepare the URL
                $url = "https://bulkapi.zerobounce.net/v2/validatebatch";

                // Make the request to ZeroBounce API
                $response = Http::post($url, [
                    'api_key' => env('ZEROBOUNCE_API_KEY'),
                    'email_batch' => $emailBatch
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    // Define status and sub-status explanations
                    $statusCodes = [
                        'valid' => 'These emails are determined to be valid and safe to email.',
                        'invalid' => 'These emails are determined to be invalid, please delete them from your mailing list.',
                        'catch-all' => 'These emails are impossible to validate without sending a real email.',
                        'spamtrap' => 'These emails are believed to be spamtraps and should not be mailed.',
                        'abuse' => 'These emails are from people known to click abuse links in emails.',
                        'do_not_mail' => 'These emails are valid, but should not be mailed under normal circumstances.',
                        'unknown' => 'These emails could not be validated at this time.',
                    ];

                    $subStatusExplanations = [
                        'alias_address' => 'These emails act as forwarders/aliases and are not real inboxes.',
                        'antispam_system' => 'These emails have anti-spam systems deployed, preventing validation.',
                        'does_not_accept_mail' => 'These domains only send mail and don’t accept it.',
                        'exception_occurred' => 'An exception occurred while validating the email.',
                        'failed_smtp_connection' => 'These emails belong to a mail server that failed SMTP connection.',
                        'failed_syntax_check' => 'These emails failed RFC syntax check.',
                        'forcible_disconnect' => 'The mail server disconnected immediately upon connection.',
                        'global_suppression' => 'These emails are in global suppression lists and should not be mailed.',
                        'greylisted' => 'The mail server temporarily denied validation; retry later.',
                        'leading_period_removed' => 'A period was removed from the start of the email address for compatibility.',
                        'mail_server_did_not_respond' => 'The mail server did not respond to validation attempts.',
                        'mail_server_temporary_error' => 'A temporary mail server error occurred.',
                        'mailbox_quota_exceeded' => 'The recipient’s mailbox is full, and the email could not be delivered.',
                        'mailbox_not_found' => 'The email address does not exist.',
                        'no_dns_entries' => 'The domain has no DNS entries.',
                        'possible_trap' => 'The email contains keywords that might indicate a spam trap.',
                        'possible_typo' => 'The email seems to be a typo of a popular domain.',
                        'role_based' => 'This is a role-based email, typically used by groups of people.',
                        'role_based_catch_all' => 'This is a role-based email in a catch-all domain.',
                        'timeout_exceeded' => 'The mail server is responding too slowly to validate the email.',
                        'unroutable_ip_address' => 'The email domain points to an unroutable IP address.',
                        'disposable' => 'This is a temporary, disposable email address.',
                        'toxic' => 'This email address is known to be toxic (abuse, spam, or bot-created).',
                        'alternate' => 'This is a valid alternate email address, often used as a secondary address.'
                    ];

                    // Process each email in the batch
                    $results = [];
                    foreach ($data['email_batch'] as $emailResult) {
                        $status = $emailResult['status'];
                        $subStatus = $emailResult['sub_status'];

                        $explanation = isset($subStatusExplanations[$subStatus])
                            ? $subStatusExplanations[$subStatus]
                            : (isset($statusCodes[$status]) ? $statusCodes[$status] : 'No specific explanation found.');

                        $results[] = [
                            'email' => $emailResult['address'],
                            'status' => $status,
                            'sub_status' => $subStatus,
                            'explanation' => $explanation
                        ];
                    }

                    // Return the processed results to the frontend
                    return response()->json([
                        'status' => 'success',
                        'data' => $results
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to validate email addresses using ZeroBounce API.'
                    ]);
                }
            } else {
                throw new Exception('Method not allowed.');
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
