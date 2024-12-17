<?php

namespace App\Http\Controllers;

use App\Models\QuoteForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuoteFormInfoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view("customer-service.quotation-form.index");
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Request()->ajax()) {
            $data = QuoteForm::findorFail($id);
            $dataContainer = [];
            $decoded_data = json_decode($data->data);
            $products = $decoded_data->ProductSelection;
            $productNames = "";
            $productInfo = "";
            $html = "";
            $utm_params = "";
            $if_gl_unchecked = "";
            foreach ($products as $product) {
                switch ($product) {
                    case "gl":
                        $multipleStateWorkInfo = "";
                        $doesUsingSubcon = "";
                        $doesHaveLosses = "";
                        if (isset($decoded_data->gl->multipleStateEntry)) {
                            $multiple_state_entries = $decoded_data->gl->multipleStateEntry;
                            foreach ($multiple_state_entries as $entry) {
                                $multipleStateWorkInfo .= "
                                    <p class='card-text'>State: {$entry->state}, Percentage: {$entry->percentage}%</p>
                                ";
                            }
                        }
                        if ($decoded_data->gl->gl_using_subcon === "Yes") {
                            $doesUsingSubcon = "<p class='card-text'>Subcon Cost: {$decoded_data->gl->gl_subcon_cost}</p>";
                        }
                        if ($decoded_data->gl->gl_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->gl->gl_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->gl->gl_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "General Liability, ";
                        $productInfo .= "
                            <h5 class='mb-2'>General Liability</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-6 mb-4'>
                                    <p class='card-text'>Annual Gross: {$decoded_data->gl->gl_annual_gross}</p>
                                    <p class='card-text'>Profession: {$decoded_data->gl->gl_profession}</p>
                                    <p class='card-text'>Residential: {$decoded_data->gl->gl_residential}%</p>
                                    <p class='card-text'>Commercial: {$decoded_data->gl->gl_commercial}%</p>
                                    <p class='card-text'>New Construction: {$decoded_data->gl->gl_new_construction}%</p>
                                    <p class='card-text'>Repair/Remodel: {$decoded_data->gl->gl_repair_remodel}%</p>
                                    <p class='card-text'>Detailed Description of Operations: {$decoded_data->gl->gl_descops}</p>
                                    <p class='card-text'>Multiple state work? {$decoded_data->gl->gl_multiple_state_work}</p>
                                    {$multipleStateWorkInfo}
                                </div>
                                <div class='col-lg-6 mb-4'>
                                    <p class='card-text'>Cost of the Largest Project in the past 5 years? {$decoded_data->gl->gl_cost_proj_5years}</p>
                                    <p class='card-text'>Full Time Employee/s: {$decoded_data->gl->gl_full_time_employees}</p>
                                    <p class='card-text'>Part Time Employee/s: {$decoded_data->gl->gl_part_time_employees}</p>
                                    <p class='card-text'>Payroll Amount: {$decoded_data->gl->gl_payroll_amt}</p>
                                    <p class='card-text'>Are you using any subcontractor? {$decoded_data->gl->gl_using_subcon}</p>
                                    {$doesUsingSubcon}
                                    <p class='card-text'>Does have Losses? {$decoded_data->gl->gl_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                            </div>
                        ";
                        break;
                    case "wc":
                        $employee_professions_entries = "";
                        $owner_information_entries = "";
                        $doesUsingSubcon = "";
                        $doesHaveLosses = "";
                        if (isset($decoded_data->wc->employeeProfessionsEntries)) {
                            $employeeProfessionsEntries = $decoded_data->wc->employeeProfessionsEntries;
                            $employee_professions_entries .= "
                                <p class='card-text'>No. of employees under this profession: ".count($employeeProfessionsEntries)."</p>
                            ";
                            foreach ($employeeProfessionsEntries as $index => $entry) {
                                $i = $index + 1;
                                $employee_professions_entries .= "
                                    <h6 class='mb-2'>Profession Entry No. {$i}</h6>
                                    <p class='card-text'>Profession Type: {$entry->profession_type}</p>
                                    <p class='card-text'>Annual Payroll: {$entry->annual_payroll}</p>
                                ";
                            }
                        }
                        if (isset($decoded_data->wc->ownersInformationEntries)) {
                            $ownerInformationEntries = $decoded_data->wc->ownersInformationEntries;
                            foreach ($ownerInformationEntries as $index => $entry) {
                                $i = $index + 1;
                                $owner_information_entries .= "
                                    <h6 class='mb-2'>Ownership Entry No. {$i}</h6>
                                    <p class='card-text'>Owner's Name: {$entry->owners_name}</p>
                                    <p class='card-text'>Owner's Title/Relationship: {$entry->owners_title_relationship}</p>
                                    <p class='card-text'>Owner's Ownership %: {$entry->owners_ownership_perc}</p>
                                    <p class='card-text'>Owner's Excluded/Included: {$entry->owners_exc_inc}</p>
                                    <p class='card-text'>Owner's SSN: {$entry->owners_ssn}</p>
                                    <p class='card-text'>Owner's FEIN: {$entry->owners_fein}</p>
                                    <p class='card-text'>Owner's Date of Birth: ".Carbon::parse($entry->owners_dob)->format("F j, Y")."</p>
                                ";
                            }
                        }
                        if ($decoded_data->wc->wc_does_hire_subcon === "Yes") {
                            $doesUsingSubcon = "<p class='card-text'>Subcon Cost: {$decoded_data->wc->wc_subcon_cost_year}</p>";
                        }
                        if ($decoded_data->wc->wc_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->wc->wc_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->wc->wc_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Workers Compensation, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Workers Compensation</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    {$employee_professions_entries}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Gross Receipt: {$decoded_data->wc->wc_gross_receipt}</p>
                                    <p class='card-text'>Do you hire subcontractor? {$decoded_data->wc->wc_does_hire_subcon}</p>
                                    {$doesUsingSubcon}
                                    <p class='card-text'>Does have Losses? {$decoded_data->wc->wc_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    {$owner_information_entries}
                                </div>
                            </div>
                        ";
                        break;
                    case "auto":
                        $vehicle_entries = "";
                        $driver_entries = "";
                        $doesDriverMarried = "";
                        $doesHaveLosses = "";
                        $productNames .= "Commercial Auto, ";
                        if (isset($decoded_data->auto->additionalVehicleEntries)) {
                            $additionalVehicleEntries = $decoded_data->auto->additionalVehicleEntries;
                            $vehicle_entries .= "
                                <p class='card-text'>No. of Vehicles: ".count($additionalVehicleEntries)."</p>
                            ";
                            foreach ($additionalVehicleEntries as $index => $entry) {
                                $i = $index + 1;
                                $vehicle_entries .= "
                                    <h6 class='mb-2'>Vehicle Entry No. {$i}</h6>
                                    <p class='card-text'>Year: {$entry->vehicle_year}</p>
                                    <p class='card-text'>Make: {$entry->vehicle_maker}</p>
                                    <p class='card-text'>Model: {$entry->vehicle_model}</p>
                                    <p class='card-text'>VIN: {$entry->vehicle_vin}</p>
                                    <p class='card-text'>Mileage: {$entry->vehicle_mileage}</p>
                                    <p class='card-text'>Garage Address: {$entry->vehicle_garage_add}</p>
                                    <p class='card-text'>Coverage Limits: $".$entry->vehicle_coverage_limits."</p>
                                ";
                            }
                        }
                        if (isset($decoded_data->auto->driverEntries)) {
                            $driverEntries = $decoded_data->auto->driverEntries;
                            $driver_entries .= "
                                <p class='card-text'>No. of Drivers: ".count($driverEntries)."</p>
                            ";
                            foreach ($driverEntries as $index => $entry) {
                                $i = $index + 1;
                                $spouseInfo = "";
                                if ($entry->drivers_civil_status === "Married") {
                                    $spouseInfo .= "<p class='card-text'>Spouse's Name: {$entry->drivers_spouse_name}</p>";
                                    $spouseInfo .= "<p class='card-text'>Spouse's Date of Birth: ".Carbon::parse($entry->drivers_spouse_dob)->format("F j, Y")."</p>";
                                }
                                $driver_entries .= "
                                    <h6 class='mb-2'>Driver Entry No. {$i}</h6>
                                    <p class='card-text'>Driver's Name: {$entry->drivers_name}</p>
                                    <p class='card-text'>Driver's License: {$entry->drivers_license}</p>
                                    <p class='card-text'>Mileage/Radius: {$entry->drivers_mileage_radius}</p>
                                    <p class='card-text'>Date of Birth: ".Carbon::parse($entry->drivers_dob)->format('F j, Y')."</p>
                                    <p class='card-text'>Civil Status: {$entry->drivers_civil_status}</p>
                                    {$spouseInfo}
                                ";
                            }
                        }
                        if ($decoded_data->auto->auto_driver_marital_status === "Married") {
                            $doesDriverMarried .= "<p class='card-text'>Spouse Name: {$decoded_data->auto->auto_driver_spouse_name}</p>";
                            $doesDriverMarried .= "<p class='card-text'>Spouse Date of Birth: ".Carbon::parse($decoded_data->auto->auto_driver_spouse_dob)->format("F j, Y")."</p>";
                        }
                        if ($decoded_data->auto->auto_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->auto->auto_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->auto->auto_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productInfo .= "
                            <h5 class='mb-2'>Commercial Auto</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    {$vehicle_entries}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Driver Full Name: {$decoded_data->auto->auto_driver_full_name}</p>
                                    <p class='card-text'>Are you the driver: {$decoded_data->auto->auto_are_you_the_driver}</p>
                                    <p class='card-text'>Date of Birth: ".Carbon::parse($decoded_data->auto->auto_driver_date_of_birth)->format("F j, Y")."</p>
                                    <p class='card-text'>Marital Status: {$decoded_data->auto->auto_driver_marital_status}</p>
                                    {$doesDriverMarried}
                                    <p class='card-text'>Driver's License: {$decoded_data->auto->auto_driver_license_no}</p>
                                    <p class='card-text'>Years of Driving Experience: {$decoded_data->auto->auto_driver_years_of_driving_exp}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->auto->auto_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    {$driver_entries}
                                </div>
                            </div>
                        ";
                        break;
                    case "bond":
                        $doesOwnerMarried = "";
                        $doesHaveLosses = "";
                        if ($decoded_data->bond->bond_owners_civil_status === "Married") {
                            $doesOwnerMarried .= "<p class='card-text'>Spouse's Name: {$decoded_data->bond->bond_owners_spouse_name}</p>";
                            $doesOwnerMarried .= "<p class='card-text'>Spouse's Date of Birth: ".Carbon::parse($decoded_data->bond->bond_owners_spouse_dob)->format("F j, Y")."</p>";
                            $doesOwnerMarried .= "<p class='card-text'>Spouse's SSN: {$decoded_data->bond->bond_owners_spouse_ssn}</p>";
                        }
                        if ($decoded_data->bond->bond_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->bond->bond_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->bond->bond_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Contractor License Bond, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Contractor License Bond</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Owner's Name: {$decoded_data->bond->bond_owners_name}</p>
                                    <p class='card-text'>Owner's SSN: {$decoded_data->bond->bond_owners_ssn}</p>
                                    <p class='card-text'>Owner's Date of Birth: ".Carbon::parse($decoded_data->bond->bond_owners_dob)->format("F j, Y")."</p>
                                    <p class='card-text'>Owner's Civil Status: {$decoded_data->bond->bond_owners_civil_status}</p>
                                    {$doesOwnerMarried}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Type of Bond Requested: {$decoded_data->bond->bond_type_bond_requested}</p>
                                    <p class='card-text'>Amount of Bond: {$decoded_data->bond->bond_amount_of_bond}</p>
                                    <p class='card-text'>Term of Bond: {$decoded_data->bond->bond_term_of_bond}</p>
                                    <p class='card-text'>Type of License: {$decoded_data->bond->bond_type_of_license}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>If other type of license: {$decoded_data->bond->bond_if_other_type_of_license}</p>
                                    <p class='card-text'>License Number or Application Number: {$decoded_data->bond->bond_license_or_application_no}</p>
                                    <p class='card-text'>Effective Date: ".Carbon::parse($decoded_data->bond->bond_effective_date)->format("F j, Y")."</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->bond->bond_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                            </div>
                        ";
                        break;
                    case "excess":
                        $doesHaveLosses = "";
                        if ($decoded_data->excess->excess_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->excess->excess_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->excess->excess_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Excess Liability, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Excess Liability</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Excess Limits: $".number_format($decoded_data->excess->excess_limits)."</p>
                                    <p class='card-text'>GL Effective Date: ".Carbon::parse($decoded_data->excess->excess_gl_eff_date)->format("F j, Y")."</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->excess->excess_no_of_losses}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    {$doesHaveLosses}
                                    <p class='card-text'>Insurance Carrier: {$decoded_data->excess->excess_insurance_carrier}</p>
                                    <p class='card-text'>Policy or Quote No.: {$decoded_data->excess->excess_policy_or_quote_no}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Policy Premium: {$decoded_data->excess->excess_policy_premium}</p>
                                    <p class='card-text'>Effective Date: ".Carbon::parse($decoded_data->excess->excess_effective_date)->format("F j, Y")."</p>
                                    <p class='card-text'>Expiration Date: ".Carbon::parse($decoded_data->excess->excess_expiration_date)->format("F j, Y")."</p>
                                </div>
                            </div>
                        ";
                        break;
                    case "tools":
                        $doesHaveLosses = "";
                        $productNames .= "Tools & Equipment, ";
                        if ($decoded_data->tools->tools_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->tools->tools_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->tools->tools_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productInfo .= "
                            <h5 class='mb-2'>Tools & Equipment</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Miscellaneous Tools Amount: {$decoded_data->tools->tools_misc_tools}</p>
                                    <p class='card-text'>Rented or Leased Amount: {$decoded_data->tools->tools_rented_or_leased_amt}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Equipment Type: {$decoded_data->tools->tools_equipment_type}</p>
                                    <p class='card-text'>Equipment Year: {$decoded_data->tools->tools_equipment_year}</p>
                                    <p class='card-text'>Equipment Make: {$decoded_data->tools->tools_equipment_make}</p>
                                    <p class='card-text'>Equipment Model: {$decoded_data->tools->tools_equipment_model}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Equipment VIN or Serial No.: {$decoded_data->tools->tools_equipment_vin_or_serial_no}</p>
                                    <p class='card-text'>Equipment Valuation: {$decoded_data->tools->tools_equipment_valuation}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->tools->tools_equipment_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                            </div>
                        ";
                        break;
                    case "br":
                        $doesHaveLosses = "";
                        $doesProjectStarted = "";
                        $doesScheduledProperty = "";
                        if ($decoded_data->br->br_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->br->br_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->br->br_date_of_loss)->format("F j, Y")."</p>";
                        }
                        if ($decoded_data->br->br_has_project_started === "Yes") {
                            $doesProjectStarted .= "
                                <p class='card-text'>When has the project started: {$decoded_data->br->br_when_project_started}</p>
                                <p class='card-text'>What are the work done: {$decoded_data->br->br_what_are_work_done}</p>
                                <p class='card-text'>Cost of work done: {$decoded_data->br->br_cost_of_work_done}</p>
                                <p class='card-text'>What are the remaining works: {$decoded_data->br->br_what_are_remaining_works}</p>
                                <p class='card-text'>Cost of remaining works: {$decoded_data->br->br_cost_remaining_works}</p>
                                <p class='card-text'>When will project start: {$decoded_data->br->br_when_will_project_start}</p>
                            ";
                        }
                        if ($decoded_data->br->br_scheduled_property_address_builders_risk_coverage === "Yes") {
                            $doesScheduledProperty .= "<p class='card-text'>Carrier Name: {$decoded_data->br->br_sched_property_carrier_name}</p>";
                            $doesScheduledProperty .= "<p class='card-text'>Effective Date: ".Carbon::parse($decoded_data->br->br_sched_property_effective_date)->format("F j, Y")."</p>";
                            $doesScheduledProperty .= "<p class='card-text'>Expiration Date: ".Carbon::parse($decoded_data->br->br_sched_property_expiration_date)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Builder's Risk, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Builder's Risk</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Property Address: {$decoded_data->br->br_property_address}</p>
                                    <p class='card-text'>Value of Existing Structure: {$decoded_data->br->br_value_of_existing_structure}</p>
                                    <p class='card-text'>Value of Work Performed: {$decoded_data->br->br_value_of_work_performed}</p>
                                    <p class='card-text'>Period/Duration of Project: {$decoded_data->br->br_period_duration_project}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->br->br_no_of_losses}</p>
                                    {$doesHaveLosses}
                                    <p class='card-text'>Construction Type: {$decoded_data->br->br_construction_type}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Complete Description of Project: {$decoded_data->br->br_complete_descops_of_project}</p>
                                    <p class='card-text'>Sq. Footage: {$decoded_data->br->br_sq_footage}</p>
                                    <p class='card-text'>Number of Floors: {$decoded_data->br->br_number_of_floors}</p>
                                    <p class='card-text'>Number of Units Dwelling: {$decoded_data->br->br_number_of_units_dwelling}</p>
                                    <p class='card-text'>Anticipated Occupancy: {$decoded_data->br->br_anticipated_occupancy}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Last update to roofing year: {$decoded_data->br->br_last_update_to_roofing_year}</p>
                                    <p class='card-text'>Last update to heating year: {$decoded_data->br->br_last_update_to_heating_year}</p>
                                    <p class='card-text'>Last update to electrical year: {$decoded_data->br->br_last_update_to_electrical_year}</p>
                                    <p class='card-text'>Last update to plumbing year: {$decoded_data->br->br_last_update_to_plumbing_year}</p>
                                    <p class='card-text'>Distance to nearest fire hydrant: {$decoded_data->br->br_distance_to_nearest_fire_hydrant}</p>
                                    <p class='card-text'>Distance to nearest fire station: {$decoded_data->br->br_distance_to_nearest_fire_station}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Structure occupied remodel/renovation: {$decoded_data->br->br_structure_occupied_remodel_renovation}</p>
                                    <p class='card-text'>When structure built: {$decoded_data->br->br_when_structure_built}</p>
                                    <p class='card-text'>Jobsite Security: {$decoded_data->br->br_jobsite_security}</p>
                                    <p class='card-text'>Has the scheduled property address had any prior Builder's Risk Coverage? {$decoded_data->br->br_scheduled_property_address_builders_risk_coverage}</p>
                                    {$doesScheduledProperty}
                                    <p class='card-text'>Residential / Commercial: {$decoded_data->br->br_residential_commercial}</p>
                                    <p class='card-text'>Has the project started: {$decoded_data->br->br_has_project_started}</p>
                                    {$doesProjectStarted}
                                </div>
                            </div>
                        ";
                        break;
                    case "bop":
                        $doesHaveLosses = "";
                        if ($decoded_data->bop->bop_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->bop->bop_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->bop->bop_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Business Owners Policy, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Business Owners Policy</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Property Address: {$decoded_data->bop->bop_property_address}</p>
                                    <p class='card-text'>Loss Payee Information: {$decoded_data->bop->bop_loss_payee_info}</p>
                                    <p class='card-text'>Building Industry: {$decoded_data->bop->bop_building_industry}</p>
                                    <p class='card-text'>Occupancy (Who owns the Building?): {$decoded_data->bop->bop_occupancy}</p>
                                    <p class='card-text'>Value of Cost of the Building? {$decoded_data->bop->bop_val_cost_bldg}</p>
                                    <p class='card-text'>What is the Business Property Limit? {$decoded_data->bop->bop_business_property_limit}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->bop->bop_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Building Construction Type: {$decoded_data->bop->bop_bldg_construction_type}</p>
                                    <p class='card-text'>Year Built: {$decoded_data->bop->bop_year_built}</p>
                                    <p class='card-text'>Number of Stories: {$decoded_data->bop->bop_no_of_stories}</p>
                                    <p class='card-text'>Total Building Sq. Ft: {$decoded_data->bop->bop_total_bldg_sqft}</p>
                                    <p class='card-text'>Automatic Sprinkler System: {$decoded_data->bop->bop_automatic_sprinkler_system}</p>
                                    <p class='card-text'>Automatic Fire Alarm: {$decoded_data->bop->bop_automatic_fire_alarm}</p>
                                    <p class='card-text'>Distance to Nearest Fire Hydrant: {$decoded_data->bop->bop_distance_nearest_fire_hydrant}</p>
                                    <p class='card-text'>Distance to Nearest Fire Station: {$decoded_data->bop->bop_distance_nearest_fire_station}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Automatic Commercial Cooking Extinguishing System: {$decoded_data->bop->bop_automatic_comm_cooking_ext}</p>
                                    <p class='card-text'>Automatic Burglar System: {$decoded_data->bop->bop_automatic_burglar_alarm}</p>
                                    <p class='card-text'>Security Cameras: {$decoded_data->bop->bop_security_cameras}</p>
                                    <p class='card-text'>Last update to roofing year: {$decoded_data->bop->bop_last_update_roofing_year}</p>
                                    <p class='card-text'>Last update to heating year: {$decoded_data->bop->bop_last_update_heating_year}</p>
                                    <p class='card-text'>Last update to plumbing year: {$decoded_data->bop->bop_last_update_plumbing_year}</p>
                                    <p class='card-text'>Last update to electrical year: {$decoded_data->bop->bop_last_update_electrical_year}</p>
                                </div>
                            </div>
                        ";
                        break;
                    case "property":
                        $doesHaveLosses = "";
                        if ($decoded_data->property->property_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->property->property_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->property->property_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Commercial Property, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Commercial Property</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Business location is located at: {$decoded_data->property->property_business_located}</p>
                                    <p class='card-text'>Property Address: {$decoded_data->property->property_property_address}</p>
                                    <p class='card-text'>Name of the owner of the building: {$decoded_data->property->property_name_of_owner}</p>
                                    <p class='card-text'>Value of Cost of the Building: {$decoded_data->property->property_value_cost_bldg}</p>
                                    <p class='card-text'>What is the Business Property Limit? {$decoded_data->property->property_business_property_limit}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->property->property_no_of_losses}</p>
                                    {$doesHaveLosses}
                                    <p class='card-text'>Do you have more than one location? {$decoded_data->property->property_does_have_more_than_one_location}</p>
                                    <p class='card-text'>Are there multiple units (residential or commercial) in your building: {$decoded_data->property->property_multiple_units}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Construction Type: {$decoded_data->property->property_construction_type}</p>
                                    <p class='card-text'>Year built: {$decoded_data->property->property_year_built}</p>
                                    <p class='card-text'>Number of Stories: {$decoded_data->property->property_no_of_stories}</p>
                                    <p class='card-text'>Total Building Sq. Ft: {$decoded_data->property->property_total_bldg_sqft}</p>
                                    <p class='card-text'>Is your building equipped with fire sprinklers? {$decoded_data->property->property_is_bldg_equipped_with_fire_sprinklers}</p>
                                    <p class='card-text'>Distance to Nearest Fire Hydrant: {$decoded_data->property->property_distance_nearest_fire_hydrant}</p>
                                    <p class='card-text'>Distance to Nearest Fire Station: {$decoded_data->property->property_distance_nearest_fire_station}</p>
                                    <p class='card-text'>Protection Class: {$decoded_data->property->property_protection_class}</p>
                                    <p class='card-text'>Select any protective devices you have: {$decoded_data->property->property_protective_device}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Last update to roofing year: {$decoded_data->property->property_last_update_roofing_year}</p>
                                    <p class='card-text'>Last update to heating year: {$decoded_data->property->property_last_update_heating_year}</p>
                                    <p class='card-text'>Last update to plumbing year: {$decoded_data->property->property_last_update_plumbing_year}</p>
                                    <p class='card-text'>Last update to electrical year: {$decoded_data->property->property_last_update_electrical_year}</p>
                                </div>
                            </div>
                        ";
                        break;
                    case "eo":
                        $doesHaveLosses = "";
                        $busEntQ1 = $busEntQ2 = $busEntQ3 = $busEntQ4 = $busEntQ5 = "";
                        $hrSubQ1 = $hrSubQ2 = $hrSubQ3 = $hrSubQ4 = "";

                        $busEntQ1 = $decoded_data->eo->eo_business_entity_q1 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_business_entity_sub_q1}</p>" : "";
                        $busEntQ2 = $decoded_data->eo->eo_business_entity_q2 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_business_entity_sub_q2}</p>" : "";
                        $busEntQ3 = $decoded_data->eo->eo_business_entity_q3 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_business_entity_sub_q3}</p>" : "";
                        $busEntQ4 = $decoded_data->eo->eo_business_entity_q4 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_business_entity_sub_q4}</p>" : "";
                        $busEntQ5 = $decoded_data->eo->eo_business_entity_q5 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_business_entity_sub_q5}</p>" : "";
                        $hrSubQ1 = $decoded_data->eo->eo_hr_q1 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_hr_sub_q1}</p>" : "";
                        $hrSubQ2 = $decoded_data->eo->eo_hr_q2 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_hr_sub_q2}</p>" : "";
                        $hrSubQ3 = $decoded_data->eo->eo_hr_q3 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_hr_sub_q3}</p>" : "";
                        $hrSubQ4 = $decoded_data->eo->eo_hr_q4 === "Yes" ? "<p class='card-text'>If Yes, please explain: {$decoded_data->eo->eo_hr_sub_q4}</p>" : "";
                        if ($decoded_data->eo->eo_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->eo->eo_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->eo->eo_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Errors and Omissions, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Errors and Omissions</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Requested Limits: {$decoded_data->eo->eo_requested_limits}</p>
                                    <p class='card-text'>Requested Deductible (Per claim): {$decoded_data->eo->eo_request_deductible}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->eo->eo_no_of_losses}</p>
                                    <p class='card-text'>If others, please indicate: {$decoded_data->eo->eo_reqdeductible_if_others}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Has the name or ownership of the entity changed within the last 5 years? {$decoded_data->eo->eo_business_entity_q1}</p>
                                    {$busEntQ1}
                                    <p class='card-text'>Has any other business been purchased merged or consolidated with the entity within the last 5 years? {$decoded_data->eo->eo_business_entity_q2}</p>
                                    {$busEntQ2}
                                    <p class='card-text'>Does any other entity own or control your business? {$decoded_data->eo->eo_business_entity_q3}</p>
                                    {$busEntQ3}
                                    <p class='card-text'>Has your company name been changed during the past 5 years? {$decoded_data->eo->eo_business_entity_q4}</p>
                                    {$busEntQ4}
                                    <p class='card-text'>Has any other business purchased, merged or consolidated with you during the past 5 years? {$decoded_data->eo->eo_business_entity_q5}</p>
                                    {$busEntQ5}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Number of Employee: {$decoded_data->eo->eo_number_employee}</p>
                                    <p class='card-text'>Full Time: {$decoded_data->eo->eo_full_time}</p>
                                    <p class='card-text'>Full Time Salary Range: {$decoded_data->eo->eo_ftime_salary_range}</p>
                                    <p class='card-text'>Part Time: {$decoded_data->eo->eo_part_time}</p>
                                    <p class='card-text'>Part Time Salary Range: {$decoded_data->eo->eo_ptime_salary_range}</p>
                                    <p class='card-text'>Has the applicant total number of employees decreased by more than ten percent (10) due to lay off, force reduction of closing of division in the past 1 year? {$decoded_data->eo->eo_emp_practice_q1}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Does the Applicant have written employment agreements with all officers? {$decoded_data->eo->eo_hr_q1}</p>
                                    {$hrSubQ1}
                                    <p class='card-text'>Does the Applicant have its employment policies/procedures reviewed by labor or employment counsel? {$decoded_data->eo->eo_hr_q2}</p>
                                    {$hrSubQ2}
                                    <p class='card-text'>Does the Applicant have a Human Resources or Personnel Department? {$decoded_data->eo->eo_hr_q3}</p>
                                    {$hrSubQ3}
                                    <p class='card-text'>Does the Applicant have an employee handbook? {$decoded_data->eo->eo_hr_q4}</p>
                                    {$hrSubQ4}
                                </div>
                            </div>
                        ";
                        break;
                    case "pollution":
                        $doesHaveLosses = "";
                        $polOpt1Lists = "";
                        $polOpt2Lists = "";
                        $polOpt3Lists = "";
                        if (!empty($decoded_data->pollution->pollution_polopt1)) {
                            $polOpt1Lists .= "<p class='card-text'>Environmental Contracting Services (Applied to Work): ";
                            foreach ($decoded_data->pollution->pollution_polopt1 as $list) {
                                $polOpt1Lists .= "{$list}, ";
                            }
                            $polOpt1Lists = rtrim($polOpt1Lists, ", ");
                            $polOpt1Lists .= "</p>";
                        }
                        if (!empty($decoded_data->pollution->pollution_polopt2)) {
                            $polOpt2Lists .= "<p class='card-text'>Environmental Contracting Services (Applied to Work): ";
                            foreach ($decoded_data->pollution->pollution_polopt2 as $list) {
                                $polOpt2Lists .= "{$list}, ";
                            }
                            $polOpt2Lists = rtrim($polOpt2Lists, ", ");
                            $polOpt2Lists .= "</p>";
                        }
                        if (!empty($decoded_data->pollution->pollution_polopt3)) {
                            $polOpt3Lists .= "<p class='card-text'>Environmental Contracting Services (Applied to Work): ";
                            foreach ($decoded_data->pollution->pollution_polopt3 as $list) {
                                $polOpt3Lists .= "{$list}, ";
                            }
                            $polOpt3Lists = rtrim($polOpt3Lists, ", ");
                            $polOpt3Lists .= "</p>";
                        }
                        if ($decoded_data->pollution->pollution_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->pollution->pollution_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->pollution->pollution_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Pollution Liability, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Pollution Liability</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>Environmental Contracting Services:</h6>
                                    <p class='card-text'>Projected Revenues $: {$decoded_data->pollution->pollution_pol_1_proj_rev}</p>
                                    <p class='card-text'>% of Subcontracted Work: {$decoded_data->pollution->pollution_pol_1_subcon_work}</p>
                                    <h6 class='mb-2'>Total Revenue for Environmental Contracting Services:</h6>
                                    <p class='card-text'>Projected Revenues $: {$decoded_data->pollution->pollution_pol_1_total_proj_rev}</p>
                                    <p class='card-text'>% of Subcontracted Work: {$decoded_data->pollution->pollution_pol_1_total_subcon_work}</p>
                                    <h6 class='mb-2'>Selected Applied to Work:</h6>
                                    {$polOpt1Lists}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>Environmental Consulting Services:</h6>
                                    <p class='card-text'>Projected Revenues $: {$decoded_data->pollution->pollution_pol_2_proj_rev}</p>
                                    <p class='card-text'>% of Subcontracted Work: {$decoded_data->pollution->pollution_pol_2_subcon_work}</p>
                                    <p class='card-text'>Projected Revenues $: {$decoded_data->pollution->pollution_pol_2_total_proj_rev}</p>
                                    <p class='card-text'>% of Subcontracted Work: {$decoded_data->pollution->pollution_pol_2_total_subcon_work}</p>
                                    <h6 class='mb-2'>Selected Applied to Work:</h6>
                                    {$polOpt2Lists}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>Non-Environmental Services:</h6>
                                    <p class='card-text'>Projected Revenues $: {$decoded_data->pollution->pollution_pol_3_proj_rev}</p>
                                    <p class='card-text'>% of Subcontracted Work: {$decoded_data->pollution->pollution_pol_3_subcon_work}</p>
                                    <p class='card-text'>Projected Revenues $: {$decoded_data->pollution->pollution_pol_3_total_proj_rev}</p>
                                    <p class='card-text'>% of Subcontracted Work: {$decoded_data->pollution->pollution_pol_3_total_subcon_work}</p>
                                    <h6 class='mb-2'>Selected Applied to Work:</h6>
                                    {$polOpt3Lists}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->pollution->pollution_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                            </div>
                        ";
                        break;
                    case "epli":
                        $doesHaveLosses = "";
                        if ($decoded_data->epli->epli_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->epli->epli_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->epli->epli_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Employment Practices Liability, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Employment Practices Liability</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>FEIN Number: {$decoded_data->epli->epli_fein}</p>
                                    <p class='card-text'>Current EPLI: {$decoded_data->epli->epli_current_epli}</p>
                                    <p class='card-text'>Prior Carrier: {$decoded_data->epli->epli_prior_carrier}</p>
                                    <p class='card-text'>Prior Carrier EPLI: {$decoded_data->epli->epli_prior_carrier_epli}</p>
                                    <p class='card-text'>Effective Date: {$decoded_data->epli->epli_effective_date}</p>
                                    <p class='card-text'>Previous Premium Amount: {$decoded_data->epli->epli_prev_premium_amount}</p>
                                    <p class='card-text'>Deductible Per Claim: {$decoded_data->epli->epli_deductible_amount}</p>
                                    <p class='card-text'>Deductible amount (If others): {$decoded_data->epli->epli_deductible_amount_if_others}</p>
                                    <p class='card-text'>Does Have Losses? {$decoded_data->epli->epli_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>How many employees are:</h6>
                                    <p class='card-text'>Full Time: {$decoded_data->epli->epli_full_time}</p>
                                    <p class='card-text'>Part Time: {$decoded_data->epli->epli_part_time}</p>
                                    <p class='card-text'>Independent Contractors: {$decoded_data->epli->epli_independent_contractors}</p>
                                    <p class='card-text'>Volunteers: {$decoded_data->epli->epli_volunteers}</p>
                                    <p class='card-text'>Leased or Seasonal: {$decoded_data->epli->epli_leased_seasonal}</p>
                                    <p class='card-text'>Non-US based Employee: {$decoded_data->epli->epli_non_us_base_emp}</p>
                                    <p class='card-text'>Total Employees: {$decoded_data->epli->epli_total_employees}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>How many employees are located at:</h6>
                                    <p class='card-text'>CA: {$decoded_data->epli->epli_located_at_ca}</p>
                                    <p class='card-text'>GA: {$decoded_data->epli->epli_located_at_ga}</p>
                                    <p class='card-text'>TX: {$decoded_data->epli->epli_located_at_tx}</p>
                                    <p class='card-text'>FL: {$decoded_data->epli->epli_located_at_fl}</p>
                                    <p class='card-text'>NY: {$decoded_data->epli->epli_located_at_ny}</p>
                                    <p class='card-text'>NJ: {$decoded_data->epli->epli_located_at_nj}</p>
                                    <h6 class='mb-2'>How many percent of employees are in the salary range of:</h6>
                                    <p class='card-text'>Up to $60,000: {$decoded_data->epli->epli_salary_range_q1}</p>
                                    <p class='card-text'>$60,000 - $120,000: {$decoded_data->epli->epli_salary_range_q2}</p>
                                    <p class='card-text'>Over $120,000: {$decoded_data->epli->epli_salary_range_q3}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>How many employees have been terminated in the last 12 months:</h6>
                                    <p class='card-text'>Voluntary: {$decoded_data->epli->epli_emp_terminated_last_12_months_q1}</p>
                                    <p class='card-text'>Involuntary: {$decoded_data->epli->epli_emp_terminated_last_12_months_q2}</p>
                                    <p class='card-text'>Laid-off: {$decoded_data->epli->epli_emp_terminated_last_12_months_q3}</p>
                                    <h6 class='mb-2'>Human Resource Policies and Procedures:</h6>
                                    <p class='card-text'>Does the Applicant have a standard employment application for all applicants? {$decoded_data->epli->epli_hr_q1}</p>
                                    <p class='card-text'>Does the Applicant have an 'At Will' provision in the employment application? {$decoded_data->epli->epli_hr_q2}</p>
                                    <p class='card-text'>Does the Applicant have an employment handbook? {$decoded_data->epli->epli_hr_q3}</p>
                                    <p class='card-text'>Does the Applicant have a written policy with respect to sexual harassment? {$decoded_data->epli->epli_hr_q4}</p>
                                    <p class='card-text'>Does the Applicant have a written policy with respect to discrimination? {$decoded_data->epli->epli_hr_q5}</p>
                                    <p class='card-text'>Does the Applicant have written annual evaluations for employees? {$decoded_data->epli->epli_hr_q6}</p>
                                </div>
                            </div>
                        ";
                        break;
                    case "cyber":
                        $doesHaveLosses = "";
                        if ($decoded_data->cyber->cyber_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->cyber->cyber_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->cyber->cyber_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Cyber Liability, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Cyber Liability</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>IT Contact Name: {$decoded_data->cyber->cyber_it_contact_name}</p>
                                    <p class='card-text'>IT Contact Number: {$decoded_data->cyber->cyber_it_contact_number}</p>
                                    <p class='card-text'>IT Contact Email: {$decoded_data->cyber->cyber_it_contact_email}</p>
                                    <p class='card-text'>Does have Losses? {$decoded_data->cyber->cyber_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Are you engaged in any of the following business activities? {$decoded_data->cyber->cyber_q1}</p>
                                    <p class='card-text'>Is there a system in place for verifying fund and wire transfers over $25,000 through a secondary means of communication prior to execution? {$decoded_data->cyber->cyber_q2}</p>
                                    <p class='card-text'>Do you store your backups offline or with a cloud service provider? {$decoded_data->cyber->cyber_q3}</p>
                                    <p class='card-text'>Do you store or process personal, health, or credit card information of more than 500,000 Individuals? {$decoded_data->cyber->cyber_q4}</p>
                                </div>
                                <div class='col-lg-4 mb-4'>
                                    <p class='card-text'>Do you enabled multi-factor authentication for email access and remote network access? {$decoded_data->cyber->cyber_q5}</p>
                                    <p class='card-text'>Do you encrypt all sensitive information at rest? {$decoded_data->cyber->cyber_q6}</p>
                                    <p class='card-text'>Any relevant claims or incidents exceeding $10,000 within the past three years? {$decoded_data->cyber->cyber_q7}</p>
                                    <p class='card-text'>Would there be any potential Cyber Event, Loss, or claim that could fall within the scope of the policy you are applying for? {$decoded_data->cyber->cyber_q8}</p>
                                </div>
                            </div>
                        ";
                        break;
                    case "instfloat":
                        $doesHaveLosses = "";
                        $sched_equipment_entries = "";
                        if (count($decoded_data->instfloat->scheduledEquipmentEntries) > 0) {
                            $scheduledEquipmentEntries = $decoded_data->instfloat->scheduledEquipmentEntries;
                            foreach ($scheduledEquipmentEntries as $index => $entry) {
                                $i = $index + 1;
                                $sched_equipment_entries .= "
                                    <h6 class='mb-2'>Scheduled Equipment Entry No. {$i}</h6>
                                    <p class='card-text'>Type: {$entry->type}</p>
                                    <p class='card-text'>MFG: {$entry->mfg}</p>
                                    <p class='card-text'>ID or Serial No.: {$entry->id_or_serial}</p>
                                    <p class='card-text'>Model: {$entry->model}</p>
                                    <p class='card-text'>New/Used: {$entry->new_or_used}</p>
                                    <p class='card-text'>Model Year: {$entry->model_year}</p>
                                    <p class='card-text'>Date Purchased: ".Carbon::parse($entry->date_purchased)->format("F j, Y")."</p>
                                ";
                            }
                        }
                        if ($decoded_data->instfloat->instfloat_no_of_losses === "Have Losses") {
                            $doesHaveLosses .= "<p class='card-text'>Amount of Claims: {$decoded_data->instfloat->instfloat_amt_of_claims}</p>";
                            $doesHaveLosses .= "<p class='card-text'>Date of Loss: ".Carbon::parse($decoded_data->instfloat->instfloat_date_of_loss)->format("F j, Y")."</p>";
                        }
                        $productNames .= "Installation Floater, ";
                        $productInfo .= "
                            <h5 class='mb-2'>Installation Floater</h5>
                            <hr />
                            <div class='row'>
                                <div class='col-lg-3 mb-4'>
                                    <p class='card-text'>Territory of Operation: {$decoded_data->instfloat->instfloat_territory_of_operation}</p>
                                    <p class='card-text'>Type of Operation: {$decoded_data->instfloat->instfloat_type_of_operation}</p>
                                    <p class='card-text'>Type of Equipment / materials you will be working with: {$decoded_data->instfloat->instfloat_scheduled_type_of_equipment}</p>
                                    <p class='card-text'>Deductible Amount: {$decoded_data->instfloat->instfloat_deductible_amount}</p>
                                    <p class='card-text'>Does have Losses? {$decoded_data->instfloat->instfloat_no_of_losses}</p>
                                    {$doesHaveLosses}
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>Equipment Storage:</h6>
                                    <p class='card-text'>Location: {$decoded_data->instfloat->instfloat_location}</p>
                                    <p class='card-text'>Months in storage: {$decoded_data->instfloat->instfloat_months_in_storage}</p>
                                    <p class='card-text'>Maximum value of equipment that you will be storing: {$decoded_data->instfloat->instfloat_max_value_of_equipment}</p>
                                    <p class='card-text'>Maximum value of building storage: {$decoded_data->instfloat->instfloat_max_value_of_bldg_storage}</p>
                                    <p class='card-text'>Type of security in place within the storage building: {$decoded_data->instfloat->instfloat_type_security_placed}</p>
                                    <h6 class='mb-2'>Unscheduled Equipment for Storage:</h6>
                                    <p class='card-text'>Type of Equipment / materials you will be working with: {$decoded_data->instfloat->instfloat_unscheduled_type_of_equipment}</p>
                                    <p class='card-text'>Maximum value of equipment that you will be storing: {$decoded_data->instfloat->instfloat_unscheduled_max_value_equipment_storing}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>Additional Information:</h6>
                                    <p class='card-text'>Equipment Rented. Loaned to/from Others with or without Operators? {$decoded_data->instfloat->instfloat_additional_info_q1}</p>
                                    <p class='card-text'>Are you Operating Equipment not listed here? {$decoded_data->instfloat->instfloat_additional_info_q2}</p>
                                    <p class='card-text'>Property used underground? {$decoded_data->instfloat->instfloat_additional_info_q3}</p>
                                    <p class='card-text'>Any work done afloat? {$decoded_data->instfloat->instfloat_additional_info_q4}</p>
                                </div>
                                <div class='col-lg-3 mb-4'>
                                    <h6 class='mb-2'>Scheduled Equipment for storage:</h6>
                                    {$sched_equipment_entries}
                                </div>
                            </div>
                        ";
                        break;
                    default:
                        break;
                }
            }
            $productNames = rtrim($productNames, ', ');
            $dataContainer['product_names'] = $productNames;
            $utm_params .= !empty($decoded_data->utmParams->utm_source) ? "<p class='card-text'>UTM Source: {$decoded_data->utmParams->utm_source}</p>" : "<p class='card-text'>No UTM Source.</p>";
            $utm_params .= !empty($decoded_data->utmParams->utm_medium) ? "<p class='card-text'>UTM Medium: {$decoded_data->utmParams->utm_medium}</p>" : "<p class='card-text'>No UTM Medium.</p>";
            $utm_params .= !empty($decoded_data->utmParams->utm_campaign) ? "<p class='card-text'>UTM Campaign: {$decoded_data->utmParams->utm_campaign}</p>" : "<p class='card-text'>No UTM Campaign.</p>";
            if (!in_array('gl', $products)) {
                $if_gl_unchecked .= "
                    <p class='card-text'>Annual Gross: {$decoded_data->aboutYourCompanyInfo->gl_annual_gross}</p>
                    <p class='card-text'>Profession: {$decoded_data->aboutYourCompanyInfo->gl_profession}</p>
                    <p class='card-text'>Residential %: {$decoded_data->aboutYourCompanyInfo->gl_residential}</p>
                    <p class='card-text'>Commercial %: {$decoded_data->aboutYourCompanyInfo->gl_commercial}</p>
                    <p class='card-text'>New Construction %: {$decoded_data->aboutYourCompanyInfo->gl_new_construction}</p>
                    <p class='card-text'>Repair/Remodel %: {$decoded_data->aboutYourCompanyInfo->gl_repair_remodel}</p>
                ";
            }
            $html .= "
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <h5 class='mb-2'>Client Information:</h5>
                            <hr />
                            <div class='col-lg-4 mb-4'>
                                <p class='card-text'>Company Name: {$decoded_data->clientInfo->company_name}</p>
                                <p class='card-text'>Client Name: {$decoded_data->clientInfo->firstname} {$decoded_data->clientInfo->lastname}</p>
                                <p class='card-text'>Address: {$decoded_data->clientInfo->address} {$decoded_data->clientInfo->city} {$decoded_data->clientInfo->states} {$decoded_data->clientInfo->zipcode}</p>
                            </div>
                            <div class='col-lg-4 mb-4'>
                                <p class='card-text'>Email Address: {$decoded_data->clientInfo->email_address}</p>
                                <p class='card-text'>Contact Number: {$decoded_data->clientInfo->phone_number}</p>
                                <p class='card-text'>Fax Number: {$decoded_data->clientInfo->fax_number}</p>
                            </div>
                            <div class='col-lg-4 mb-4'>
                                <p class='card-text'>Personal Website: {$decoded_data->clientInfo->personal_website}</p>
                                <p class='card-text'>Contractor License: {$decoded_data->clientInfo->contractor_license}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <h5 class='mb-2'>About Your Company Details:</h5>
                            <hr />
                            <div class='col-lg-4 mb-4'>
                                <p class='card-text'>Business Ownership Structure: {$decoded_data->aboutYourCompanyInfo->ayc_bop}</p>
                                <p class='card-text'>Date Business Started: ".Carbon::parse($decoded_data->aboutYourCompanyInfo->ayc_date_business_started)->format("F j, Y")."</p>
                            </div>
                            <div class='col-lg-4 mb-4'>
                                <p class='card-text'>Years in Business? {$decoded_data->aboutYourCompanyInfo->ayc_yrs_in_business}</p>
                                <p class='card-text'>Years of experience as a contractor? {$decoded_data->aboutYourCompanyInfo->ayc_yrs_exp_contractor}</p>
                            </div>
                            <div class='col-lg-4 mb-4'>
                                {$if_gl_unchecked}
                            </div>
                        </div>
                    </div>
                </div>
                <div class='card'>
                    <div class='card-body'>
                        {$productInfo}
                    </div>
                </div>
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-12'>
                                <h5 class='mb-2'>UTM Sources</h5>
                                <hr />
                                {$utm_params}
                            </div>
                        </div>
                    </div>
                </div>
            ";
            return response()->json(['result' => [$html]]);
        }
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
        // dd($request->all());
        if ($request->ajax()) {
            // Validate the request
            $request->validate([
                'status' => 'required|string|in:Pending,Processing,Declined,Completed',
            ]);

            // Find the QuoteForm by ID
            $quoteForm = QuoteForm::findOrFail($id);

            // Update the status
            $quoteForm->status = $request->input('status');
            $quoteForm->save();

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

    public function quoteFormTable(Request $request) {
        if ($request->ajax() && $request->isMethod('POST')) {
            $data = QuoteForm::orderByDesc('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function($data) {
                    $decoded_data = json_decode($data->data);
                    $company_name = isset($decoded_data->clientInfo->company_name) ? $decoded_data->clientInfo->company_name : 'N/A';
                    return $company_name;
                })
                ->addColumn('client_name', function($data) {
                    $decoded_data = json_decode($data->data);
                    $client_name = isset($decoded_data->clientInfo->firstname) ? $decoded_data->clientInfo->firstname . ' ' . $decoded_data->clientInfo->lastname : 'N/A';
                    return $client_name;
                })
                ->addColumn('email_address', function($data) {
                    $decoded_data = json_decode($data->data);
                    $email_address = isset($decoded_data->clientInfo->email_address) ? $decoded_data->clientInfo->email_address : 'N/A';
                    return $email_address;
                })
                ->addColumn('contact_number', function($data) {
                    $decoded_data = json_decode($data->data);
                    $contact_number = isset($decoded_data->clientInfo->phone_number) ? $decoded_data->clientInfo->phone_number : 'N/A';
                    return $contact_number;
                })
                ->addColumn('products_selected', function($data) {
                    $decoded_data = json_decode($data->data);
                    $productNames = '<span class="badge bg-primary">';
                    foreach ($decoded_data->ProductSelection as $product) {
                        switch ($product) {
                            case "gl":
                                $productNames .= "General Liability, ";
                                break;
                            case "wc":
                                $productNames .= "Workers Compensation, ";
                                break;
                            case "auto":
                                $productNames .= "Commercial Auto, ";
                                break;
                            case "bond":
                                $productNames .= "Contractors Bond, ";
                                break;
                            case "excess":
                                $productNames .= "Excess Liability, ";
                                break;
                            case "tools":
                                $productNames .= "Tools & Equipment, ";
                                break;
                            case "br":
                                $productNames .= "Builders Risk, ";
                                break;
                            case "bop":
                                $productNames .= "Business Owners Policy, ";
                                break;
                            case "property":
                                $productNames .= "Commercial Property, ";
                                break;
                            case "eo":
                                $productNames .= "Errors and Omission, ";
                                break;
                            case "pollution":
                                $productNames .= "Pollution Liability, ";
                                break;
                            case "epli":
                                $productNames .= "Employment Practices Liability, ";
                                break;
                            case "cyber":
                                $productNames .= "Cyber Liability, ";
                                break;
                            case "instfloat":
                                $productNames .= "Installation Floater, ";
                                break;
                            default:
                                break;
                        }
                    }
                    $productNames = rtrim($productNames, ', ');
                    $productNames .= '</span>';
                    return $productNames;
                })
                ->addColumn('utm_sources', function($data) {
                    $decoded_data = json_decode($data->data);
                    $utm_sources = [];
                    $utm_sources[] = !empty($decoded_data->utmParams->utm_source) ? "UTM Source: " . $decoded_data->utmParams->utm_source : "No UTM Source";
                    $utm_sources[] = !empty($decoded_data->utmParams->utm_medium) ? "UTM Medium: " . $decoded_data->utmParams->utm_medium : "No UTM Medium";
                    $utm_sources[] = !empty($decoded_data->utmParams->utm_campaign) ? "UTM Campaign: " . $decoded_data->utmParams->utm_campaign : "No UTM Campaign";
                    $utm_sources_string = implode(', ', $utm_sources);
                    return $utm_sources_string;
                })
                ->addColumn('status', function($data) {
                    $account_status = isset($data->status) ? $data->status : 'N/A';
                    return $account_status;
                })
                ->addColumn('action', function($data) {
                    $actionBtn = "
                        <button type='button' class='btn btn-outline-primary btn-sm waves-effect waves-light view' id='{$data->id}' style='width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;'><i class='ri-eye-line'></i></button>
                        <button type='button' class='btn btn-info btn-sm waves-effect waves-light edit' id='{$data->id}' style='width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;'><i class='ri-pencil-line'></i></button>
                    ";
                    return $actionBtn;
                })
                ->rawColumns(['products_selected', 'action'])
                ->make(true);
        }
    }
}
