<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HrController extends Controller
{
    public function showAccountabilityForm()
    {
        return view('hr.other-forms.accountability-form.index');
    }

    public function showIncidentReportForm() {
        return view('hr.other-forms.incident-report-form.index');
    }

    // public function generateAccountabilityFormPDF()
    // {
    // }
}
