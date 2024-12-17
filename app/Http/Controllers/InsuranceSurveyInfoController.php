<?php

namespace App\Http\Controllers;

use App\Models\CalculatorTrades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\InsuranceNeedsSurveyForm;
use Yajra\DataTables\Facades\DataTables;
use App\Models\InsuranceNeedsSurveyFormApi;

class InsuranceSurveyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("customer-service.insurance-needs-survey-form.index");
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
        try {
            if ($request->isMethod('post')) {
                $encodedData = json_encode($request->all());
                // DB::beginTransaction();
                $insuranceNeedsSurveyForm = InsuranceNeedsSurveyForm::create([
                    'data' => $encodedData,
                    'status' => 'Pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                // DB::commit();
                if ($insuranceNeedsSurveyForm) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Form submitted successfully',
                        'data' => $insuranceNeedsSurveyForm
                    ]);
                } else {
                    throw new \Exception('Form submission failed');
                }
            } else {
                throw new \Exception('Invalid request');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
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
        if ($request->ajax()) {
            // Validate the request
            $request->validate([
                'status' => 'required|string|in:Pending,Processing,Declined,Completed',
            ]);

            // Find the QuoteForm by ID
            $insuranceNeedsSuveyForm = InsuranceNeedsSurveyForm::findOrFail($id);

            // Update the status
            $insuranceNeedsSuveyForm->status = $request->input('status');
            $insuranceNeedsSuveyForm->save();

            // Return a success response
            return response()->json(['result' => 'Status updated successfully!']);
        }

        // Return an error response if the request is not an AJAX request
        return response()->json(['error' => 'Invalid request.'], 400);
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

    public function insuranceNeedsInfoTable(Request $request) {
        if ($request->ajax() && $request->isMethod('POST')) {
            $data = InsuranceNeedsSurveyForm::orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function($data) {
                    $decoded_data = json_decode($data->data);
                    $company = isset($decoded_data->company_name) ? $decoded_data->company_name : 'N/A';
                    return $company;
                })
                ->addColumn('client_name', function($data) {
                    $decoded_data = json_decode($data->data);
                    $firstname = isset($decoded_data->first_name) ? $decoded_data->first_name : 'N/A';
                    $lastname = isset($decoded_data->last_name) ? $decoded_data->last_name : 'N/A';
                    $client_name = "{$firstname} {$lastname}";
                    return $client_name;
                })
                ->addColumn('email_address', function($data) {
                    $decoded_data = json_decode($data->data);
                    $email_address = isset($decoded_data->email) ? $decoded_data->email : 'N/A';
                    return $email_address;
                })
                ->addColumn('contact_number', function($data) {
                    $decoded_data = json_decode($data->data);
                    $contact_number = isset($decoded_data->phone_no) ? $decoded_data->phone_no : 'N/A';
                    return $contact_number;
                })
                ->addColumn('trades_selected', function($data) {
                    $decoded_data = json_decode($data->data);
                    $calcu_trades = new CalculatorTrades;
                    $trade_names = $calcu_trades->getTradeNames($decoded_data->trades_performed);
                    $trade_names_html = '';
                    if (!empty($trade_names)) {
                        foreach ($trade_names as $trade) {
                            $trade_names_html .= "<span class='badge bg-primary me-1'>{$trade}</span> ";
                        }
                    } else {
                        $trade_names_html = 'N/A';
                    }

                    return $trade_names_html;
                })
                ->addColumn('utm_sources', function($data) {
                    $decoded_data = json_decode($data->data);
                    $utm_sources = [];
                    $utm_sources[] = !empty($decoded_data->utm_source) ? "UTM Source: " . $decoded_data->utm_source : "No UTM Source";
                    $utm_sources[] = !empty($decoded_data->utm_medium) ? "UTM Medium: " . $decoded_data->utm_medium : "No UTM Medium";
                    $utm_sources[] = !empty($decoded_data->utm_campaign) ? "UTM Campaign: " . $decoded_data->utm_campaign : "No UTM Campaign";
                    $utm_sources_string = implode(', ', $utm_sources);
                    return $utm_sources_string;
                })
                ->addColumn('file_report', function($data) {
                    $id = $data->id;
                    $file_url = route('insurance-needs-report', ['id' => $id]);
                    return "
                        <a href='{$file_url}' target='_blank'>
                            <i class='ri-file-pdf-line'></i> View Report
                        </a>
                    ";
                })
                ->addColumn('status', function($data) {
                    $status = $data->status;
                    return $status;
                })
                ->addColumn('action', function($data) {
                    $actionBtn = "
                        <button type='button' class='btn btn-info btn-sm waves-effect waves-light edit' id='{$data->id}' style='width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;'><i class='ri-pencil-line'></i></button>
                    ";
                    return $actionBtn;
                })
                ->rawColumns(['trades_selected', 'file_report', 'action'])
                ->make(true);
        }
    }

    public function downloadReport($id)
    {
        // Fetch the API key
        $insuranceNeedsSurveyForm = new InsuranceNeedsSurveyFormApi();
        $apiKey = $insuranceNeedsSurveyForm->getCurrentApiKey();

        // Make the request to the API with headers
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Accept' => 'application/pdf'
        ])->get("http://127.0.0.1:8000/api/v1/get-generated-pdf/{$id}");

        // Check if the request was successful
        if ($response->successful()) {
            // Extract the filename from the Content-Disposition header, if available
            $contentDisposition = $response->header('Content-Disposition');
            $filename = 'report.pdf'; // Default filename

            if ($contentDisposition && preg_match('/filename[^;=\n]*=((["\']).*?\2|[^;\n]*)/', $contentDisposition, $matches)) {
                $filename = trim($matches[1], ' "');
            }

            // Return the PDF file as a download with the correct filename
            return response($response->body(), 200)
                ->header("Content-Type", "application/pdf")
                ->header("Content-Disposition", "inline; filename='{$filename}'");
        } else {
            // Handle error, e.g., return a message or redirect back
            return redirect()->back()->withErrors('Unable to download PDF. Please try again.');
        }
    }

}