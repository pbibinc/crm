<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF;

class TecnickcomPdfController extends Controller
{
    public function Header()
    {
        $headerImage = public_path('Insuraprime.png'); // Path to the header image

        list($width, $height, $type, $attr) = getimagesize($headerImage); // Get the dimensions of the image
        $headerImageWidth = 50; // Desired width of the header image
        $headerImageHeight = $height * ($headerImageWidth / $width); // Calculate the height to maintain the aspect ratio

        $headerImageX = ($this->getPageWidth() - $headerImageWidth) / 2; // Calculate X position for centering the image
        $headerImageY = 10; // Set Y position for the image

        $this->Image(asset($headerImage), $headerImageX, $headerImageY, $headerImageWidth, $headerImageHeight, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function generatePdf(Request $request)
    {
        // $name = $request->input('name');
        // $email = $request->input('email');

        $pdf = new TCPDF; // Create a new instance of this controller
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Your Name');
        $pdf->setTitle('Form Data PDF');
        $pdf->setSubject('Form Data');

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $pdf->SetY(60);

        // $pdf->Cell(0, 10, 'Name: ' . $name, 0, 1);
        // $pdf->Cell(0, 10, 'Email: ' . $email, 0, 1);

        // Table with auto-adjust
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(85, 8, 'Description', 1);
        $pdf->Cell(85, 8, 'Value', 1, 1);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(85, 8, 'Name', 1);
        // $pdf->Cell(95, 8, $name, 1, 1);
        $pdf->Cell(85, 8, 'Email', 1);
        // $pdf->Cell(95, 8, $email, 1, 1);

        $pdf->Output('form_data.pdf', 'I');
    }
}
