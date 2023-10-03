<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Previous Commercial Auto Policy</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Miscellaneous Tools Amount:</b>
                {{ $generalInformation->toolsEquipment->misc_tools_amount}}
            </div>
            <div class="col-6">
                <b>Rented/Leased Equipment Amount:</b>
                {{ $generalInformation->toolsEquipment->rented_less_equipment }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Scheduled Equipment:</b>
                {{ $generalInformation->toolsEquipment->scheduled_equipment}}
            </div>
            <div class="col-6">
                <b>Deductible Amount:</b>
                {{ $generalInformation->toolsEquipment->deductible_amount }}
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Tools/Equipments</h4>
        </div>
        <div class="row mb-4">
             @foreach ($generalInformation->toolsEquipment->equipmentInformation as $toolsEquipment)
             <div class="col-6 mb-4">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="row mb-4">
                            <h4 class="card-title">Tools/Equipments Information</h4>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <b>equipment:</b>
                                {{ $toolsEquipment->equipment }}
                            </div>
                            <div class="col-6">
                                <b>year:</b>
                                {{ $toolsEquipment->year }}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <b>make:</b>
                                {{ $toolsEquipment->make }}
                            </div>
                            <div class="col-6">
                                <b>model:</b>
                                {{ $toolsEquipment->model }}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <b>value:</b>
                                {{ $toolsEquipment->value }}
                            </div>
                            <div class="col-6">
                                <b>year acquired:</b>
                                {{ $toolsEquipment->year_acquired }}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <b>serial identification number:</b>
                                {{ $toolsEquipment->serial_identification_no }}
                            </div>


                        </div>
                    </div>
                </div>
             </div>
             @endforeach
        </div>

    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Tools Equipment Previous Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Expiration of Commercial Auto:</b>
                {{ \Carbon\Carbon::parse($generalInformation->lead->toolsEquipmentExpirationProduct->expiration_date)->format('M-j-Y') }}
            </div>
            <div class="col-6">
                <b>Prior Carrier:</b>
                {{ $generalInformation->lead->toolsEquipmentExpirationProduct->prior_carrier }}
            </div>
        </div>
    </div>
</div>
