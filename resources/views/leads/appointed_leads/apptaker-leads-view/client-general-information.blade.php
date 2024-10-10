<div class="d-flex align-items-center justify-content-between">
    <h5 class="mt-3">Address</h5>
    <button class="btn btn-light btn-sm waves-effect waves-light" id="editGeneralInformationButton"><i
            class="ri-edit-2-line"></i></button>
</div>

<ul class="list-group">
    <li class="list-group-item">
        <i class="fas fa-map-marker-alt"></i>
        <span>{{ $leads->GeneralInformation->address }}</span>
    </li>
    <li class="list-group-item">
        <i class="fas fa-city"></i>
        <span>{{ $leads->GeneralInformation->state }}</span>
    </li>
    <li class="list-group-item">
        <i class="fas fa-location-arrow"></i>
        <span>{{ $leads->GeneralInformation->zipcode }}</span>
    </li>
</ul>

<h5 class="card-title mt-3">Cost Info</h5>
<ul class="list-group">
    <li class="list-group-item">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Gross Receipt: ${{ number_format($leads->GeneralInformation->gross_receipt, 2) }}</span>
    </li>
    <li class="list-group-item">
        <i class="fas fa-money-check-alt"></i>
        <span>Owners Payroll: ${{ number_format($leads->GeneralInformation->owners_payroll, 2) }}</span>
    </li>
    <li class="list-group-item">
        <i class="fas fa-hand-holding-usd"></i>
        <span>Employees Payroll: ${{ number_format($leads->GeneralInformation->employee_payroll, 2) }}</span>
    </li>
    <li class="list-group-item">
        <i class=" fas fa-wallet"></i>
        <span>Material Cost: ${{ number_format($leads->GeneralInformation->material_cost, 2) }}</span>
    </li>
    <li class="list-group-item">
        <i class="fas fa-handshake"></i>
        <span>Sub Out: ${{ number_format($leads->GeneralInformation->sub_out, 2) }}</span>
    </li>
</ul>


<h5 class="card-title mt-3">Employees</h5>
<ul class="list-group">
    <li class="list-group-item">
        <i class="fas fa-user-friends"></i>
        <span>Fulltime Employee: {{ $leads->GeneralInformation->full_time_employee }}</span>
    </li>
    <li class="list-group-item">
        <i class="fas fa-user-friends"></i>
        <span>Parttime Employee: {{ $leads->GeneralInformation->part_time_employee }}</span>
    </li>

</ul>


<h5 class="card-title mt-3">Works Info</h5>
<ul class="list-group">

    <li class="list-group-item">
        <i class="fas fa-hard-hat"></i>
        <span>All Trade Work: {{ $leads->GeneralInformation->all_trade_work }}</span>
    </li>
</ul>
<script>
    $(document).ready(function() {
        $('#editGeneralInformationButton').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = "{{ $leads->id }}";
            console.log(id);
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: id,
                },
            });
            window.open(`${url}general-information-form/edit`, "s_blank",
                "width=1000,height=849");
        });
    });
</script>
