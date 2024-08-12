<style>
    .title-card {
        background-color: #656565;
        /* Bootstrap primary color */
        padding: 10px 15px;
        border-radius: 5px;
        color: #ffffff;
        ;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .title-icon {
        margin-right: 10px;
    }
</style>
@if ($actionButtons == true)
    <div class="row mb-4">
        <div class="col-md-6">
            <button type="button" class="editToolsEquipment btn btn-primary"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif
<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-tools-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Tools Equipment Information</h4>
    </div>

</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Miscellaneous Tools Amount:</b>
        {{ $generalInformation->toolsEquipment->misc_tools_amount }}
    </div>
    <div class="col-6">
        <b>Rented/Leased Equipment Amount:</b>
        {{ $generalInformation->toolsEquipment->rented_less_equipment }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Scheduled Equipment:</b>
        {{ $generalInformation->toolsEquipment->scheduled_equipment }}
    </div>
    <div class="col-6">
        <b>Deductible Amount:</b>
        {{ $generalInformation->toolsEquipment->deductible_amount }}
    </div>
</div>
<div class="row">
    <hr>
</div>


<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="mdi mdi-excavator title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Tools/Equipments</h4>
    </div>
</div>
<div class="row mb-4">
    @foreach ($generalInformation->toolsEquipment->equipmentInformation as $index => $toolsEquipment)
        <div class="col-6 mb-4">
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <h4 class="card-title">Tools/Equipments Information #{{ $index + 1 }}</h4>
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
<div class="row">
    <hr>
</div>

<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-calendar-event-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Previous Tools Equipment Information</h4>
    </div>
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
<script>
    $(document).ready(function() {
        $('.editToolsEquipment').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var leadId = $(this).val();
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: leadId
                },
            });
            window.open(`${url}tools-equipment-form/edit`, "s_blank",
                "width=1000,height=849")
        });
    });
</script>
