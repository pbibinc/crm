<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{

    private function blankUnderline($pdf, $x, $y, $width)
    {
        $pdf::SetLineWidth(1);
        $pdf::Line($x, $y, $x + $width, $y);
    }

    private function drawTable($pdf, $x, $y, $tableHeaderDatas)
    {
        $row_height = 8; // Set the height of each table row
        $column_widths = [30, 50, 40, 30, 30]; // Set the widths of each table column

        // Draw the table rows
        $i = 0;
        foreach ($tableHeaderDatas as $tableHeaderData) {
            // Bold for the header row
            if ($i == 0) {
                $pdf::SetFont('dejavusans', 'B', 12); // Make the header row text bold
            } else {
                $pdf::SetFont('dejavusans', '', 12); // Set the font for the rest of the rows
            }

            $pdf::SetX($x);
            $pdf::Cell($column_widths[0], $row_height, $tableHeaderData['sn'], 1, 0, 'C', 0);
            $pdf::Cell($column_widths[1], $row_height, $tableHeaderData['description'], 1, 0, 'C', 0);
            $pdf::Cell($column_widths[2], $row_height, $tableHeaderData['qty'], 1, 0, 'C', 0);
            $pdf::Cell($column_widths[3], $row_height, $tableHeaderData['unit_price'], 1, 0, 'C', 0);
            $pdf::Cell($column_widths[4], $row_height, $tableHeaderData['amount'], 1, 0, 'C', 0);

            $y += $row_height;
            $pdf::SetY($y);
            $i++;
        }

        return $y - $row_height; // Return the height of the table
    }

    public function generateAccountabilityFormPdf(Request $request)
    {
        // Decode the JSON data from the AJAX request into an associative array
        $data = json_decode($request->getContent(), true);

        // Initialize variable that will use $pdf
        $pdf = new PDF;

        // Set Filename
        $currentDate = Carbon::now();
        $currentYear = $currentDate->format('F j, Y');
        $filename = "Accountability Form - " . $currentYear . ".pdf";

        // Table Datas
        $tableHeaderDatas = [
            [
                'sn' => 'SN',
                'description' => 'Description',
                'qty' => 'Quantity',
                'unit_price' => 'Unit Price',
                'amount' => 'Amount',
            ],
        ];

        $userName = $data['user_name'];

        // Loop through the records array
        for ($i = 1; $i < count($data['records']) + 1; $i++) {
            $record = $data['records'][$i - 1];
            // Merge the record with the $tableHeaderDatas array
            $tableHeaderDatas[] = [
                'sn' => $record["sn{$i}"],
                'description' => $record["description{$i}"],
                'qty' => $record["qty{$i}"],
                'unit_price' => "₱" . $record["unit_price{$i}"],
                'amount' => "₱" . $record["amount{$i}"],
            ];
        }

        // Other Datas
        $otherData = [
            'title' => 'Accountability Form',
            'user' => $userName,
            'preparedby' => auth()->user()->name,
        ];

        // Setup PDF Template
        // Edit values on "tcpdf.php" config
        $pdf::SetCreator(PDF_CREATOR);
        $pdf::SetAuthor('InsuraPrime');
        $pdf::setTitle('Accountability Form - ' . $currentYear);

        // Set default header data
        $pdf::SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 055', PDF_HEADER_STRING);

        // Set header and footer fonts
        $pdf::setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set margins
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Render on the blade template
        $html = view()->make('pdfSample', $otherData)->render();

        // array of font names
        // $core_fonts = array('courier', 'courierB', 'courierI', 'courierBI', 'helvetica', 'helveticaB', 'helveticaI', 'helveticaBI', 'times', 'timesB', 'timesI', 'timesBI', 'symbol', 'zapfdingbats');

        // Contents Starts Here
        $pdf::AddPage();

        // PBIB Logo
        $placeholder_start = strpos($html, '<div id="image-placeholder">') + strlen('<div id="image-placeholder">');
        $placeholder_end = strpos($html, '</div>', $placeholder_start);

        // Get the page width and calculate the x-coordinate required to center the image
        $page_width = $pdf::getPageWidth();
        $image_width = 150; // The width of your image
        $x = ($page_width - $image_width) / 2;

        // Insert the image using the Image() method
        // $image_html = $pdf::Image(asset('images/Insuraprime.png'), $x, 0, $image_width, 60, '', '', '', false, 300, '', false, false, 0, false, false, false);
        $image_html = $pdf::Image(public_path('images/Insuraprime.png'), $x, 0, $image_width, 60, '', '', '', false, 300, '', false, false, 0, false, false, false);
        $html = substr_replace($html, $image_html, $placeholder_start, $placeholder_end - $placeholder_start);

        // To Print Special Characters like Pesos Sign
        $pdf::SetFont('dejavusans', '', 12);
        $pdf::writeHTML($html, true, false, true, false, 'center');

        // Table
        $table_start_x = 20;
        $table_start_y = 131.5;
        $table_end_y = $this->drawTable($pdf, $table_start_x, $table_start_y, $tableHeaderDatas);

        // Add a margin below the table
        $contents_start_y = $table_end_y + 10;
        // $pdf::Text(20, $contents_start_y, 'This is the content below the table.');

        // Draw a blank underline
        $x = 20; // Set the x-coordinate for the starting point of the underline
        $y = 200; // Set the y-coordinate for the starting point of the underline
        $width = 100; // Set the width of the underline
        $this->blankUnderline($pdf, $x, $y, $width);

        // Auto-populate the underline with data
        // $data = 'John Doe'; // Replace this with the data you want to display
        $margin = 2; // Set the margin between the text and the underline
        $pdf::Text($x, $y - $pdf::getFontSize() - $margin, $otherData['user']);
        $pdf::Text(80, $y - $pdf::getFontSize() - $margin, $currentYear);

        // Add a description below the underline
        $description = 'Employee’s Signature over Printed Name/Date';
        $desc_margin = 4; // Set the margin between the underline and the description
        $pdf::Text($x, $y + $desc_margin, $description);

        $pdf::Text($x, 215 + $desc_margin, 'Prepared/Issued By: ' . $otherData['preparedby']);

        $pdf::Text($x, 235 + $desc_margin, 'Marianne Doministo');
        $pdf::Text($x, 240 + $desc_margin, 'HR Assistant');

        $pdf::Text($x + 130, 235 + $desc_margin, 'Rea Jong');
        $pdf::Text($x + 130, 240 + $desc_margin, 'General Manager');

        // Generate the PDF file and encode it in base64
        $content = $pdf::Output($filename, 'S');
        $base64Pdf = base64_encode($content);

        // Return a JSON response with the base64-encoded PDF
        return response()->json([
            'success' => true,
            'pdf_base64' => $base64Pdf,
        ]);

        // $pdfUrl = public_path($filename);

        // Return a JSON response with the PDF URL
        // return response()->json([
        //     'success' => true,
        //     'pdf_url' => $pdfUrl, // Replace with the actual URL to the generated PDF
        // ]);

        // return response($content, 200)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename="' . $filename . '"');

        // If downloadable
        // $pdf::Output(public_path($filename), 'F');

        // return response()->download(public_path($filename));

    }

    public function generateIncidentReportFormPdf(Request $request) {
        
    }

    public function index()
    {
    }
}
