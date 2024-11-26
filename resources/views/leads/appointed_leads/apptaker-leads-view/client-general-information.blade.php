<div class="d-flex align-items-center justify-content-between">
    <h5 class="mt-3">Address</h5>
    <div>
        <button class="btn btn-light btn-sm waves-effect waves-light" id="editGeneralInformationButton"><i
                class="ri-edit-2-line"></i></button>
        <button class="btn btn-success btn-sm waves-effect waves-light" id="addProductButton"><i class="ri-add-line"></i>
            ADD PRODUCT</button>
        <button class="btn btn-info btn-sm waves-effect waves-light" id="accountSetting"><i
                class="ri-user-settings-line"></i>
            ACC SETTING</button>
    </div>

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

<div class="modal fade" id="customerUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="customerUserModalForm">
                @csrf
                <div class="modal-body">
                    <select name="customerUserDropdown" id="customerUserDropdown" class="select form-control">
                        <option value="">Select User</option>
                        @foreach ($customerUsers as $customerUser)
                            <option value="{{ $customerUser->id }}">{{ $customerUser->email }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="leadId" id="leadId" value={{ $leads->id }}>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="ok_button" id="ok_button">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>


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

        $('#addProductButton').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = "{{ $leads->id }}";
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
            window.open(`${url}add-product-form`, "s_blank",
                "width=1000,height=849");
        });

        $('#customerUserDropdown').on('hide-bs-modal', function() {
            $('#customerUserModalForm')[0].reset();
        });

        $('#accountSetting').on('click', function() {
            $.ajax({
                url: "{{ route('customer-account-setting.edit', ':id') }}".replace(':id',
                    "{{ $leads->id }}"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'GET',
                success: function(data) {
                    if (data.user) {
                        $('#customerUserDropdown').val(data.user.id);
                    }
                    $('#customerUserModal').modal('show');

                },
                error: function(data) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Customer User Not Added',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            })

        });

        $('#customerUserModalForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $('#customerUserModalForm').serialize();
            $.ajax({
                url: "{{ route('customer-account-setting.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: formData,
                success: function(data) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Customer User Added Successfully',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#customerUserModal').modal('hide');
                        }
                    })
                },
                error: function(data) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Customer User Not Added',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            })
        });

    });
</script>
