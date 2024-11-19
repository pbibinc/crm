<style>
    .row-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .title-card {
        background-color: #4E5D6C;
        /* Darker shade for a more modern look */
        padding: 8px 15px;
        border-radius: 4px;
        color: #ffffff;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        font-size: 16px;
        /* Slightly larger font size for headings */
    }

    .title-icon {
        font-size: 18px;
        /* Larger icons for better visibility */
        margin-right: 8px;
    }

    .data-section {
        padding: 5px 15px;
        /* Reduced padding for compactness */
        background-color: #F7F7F7;
        /* Light grey background for data sections */
        border-left: 5px solid #4E5D6C;
        /* Accent border matching title cards */
        margin-bottom: 10px;
    }

    .data-label {
        font-weight: bold;
        color: #333333;
        /* Darker text for better readability */
        display: block;
        /* Ensure label is on its own line */
    }

    .data-value {
        margin-left: 5px;
        font-size: 14px;
        /* Smaller font size for data values */
    }

    .inline-data {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .inline-data .col-6 {
        display: flex;
        flex-direction: row;
        align-items: center;
    }


    .tools-card {
        border: 1px solid #66BB6A;
        background-color: #E8F5E9;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .tools-title {
        color: #388E3C;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .tools-info {
        margin-bottom: 10px;
        font-size: 14px;
    }

    .tools-info b {
        color: #333;
    }

    .tools-card .card-body {
        padding: 10px;
    }

    .btn-sm {
        padding: 4px 8px;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border-top: 1px solid #DDD;
        /* Lighter line for subtlety */
    }
</style>
{{-- @if ($actionButtons == true)
    <div class="row mb-4">
        <div class="col-md-6">
            <button type="button" class="editToolsEquipment btn btn-primary"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif --}}
@php
    $toolsEquipmentProduct = $generalInformation->lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
        'Tools Equipment',
        $generalInformation->lead->quoteLead->QuoteInformation->id,
    );
@endphp
<div class="row-title">
    <div class="card-title">
        <h5>Tools Equipment Profile</h5>
        @if ($toolsEquipmentProduct->status == 5)
            <span class="badge bg-danger align-middle">Declined</span>
        @endif
    </div>
    <div>
        @if ($actionButtons == true)
            <button type="button" class="editToolsEquipment btn btn-light btn-sm waves-effect waves-light"
                value="{{ $generalInformation->lead->id }}">
                <i class="ri-edit-line"></i> Edit
            </button>
        @endif
        @if ($toolsEquipmentProduct->status == 29)
            <button type="button"
                class="sendAppointedToolsEquipmentForQuotation btn btn-success btn-sm waves-effect waves-light"
                value="{{ $toolsEquipmentProduct->id }}">
                <i class="ri-task-line"></i> Send For Quotation
            </button>
        @elseif($toolsEquipmentProduct->status == 1)
            <button type="button"
                class="sendOutToolsEquipmentQuotation btn btn-success btn-sm waves-effect waves-light"
                value="{{ $toolsEquipmentProduct->id }}">
                <i class="ri-task-line"></i> Send Out Quotation</button>
        @elseif($toolsEquipmentProduct->status == 5)
            <button type="button"
                class="sendAppointedToolsEquipmentForQuotation btn btn-warning btn-sm waves-effect waves-light"
                value="{{ $toolsEquipmentProduct->id }}">Resend For Quotation</button>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-tools-line title-icon"></i>
            <span>Tools Equipment Information</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Miscellaneous Tools Amount:</span>
                    <span class="data-value">{{ $generalInformation->toolsEquipment->misc_tools_amount }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Rented/Leased Equipment Amount:</span>
                    <span class="data-value">{{ $generalInformation->toolsEquipment->rented_less_equipment }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Scheduled Equipment:</span>
                    <span class="data-value"> {{ $generalInformation->toolsEquipment->scheduled_equipment }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Deductible Amount:</span>
                    <span class="data-value"> {{ $generalInformation->toolsEquipment->deductible_amount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="mdi mdi-excavator title-icon"></i>
            <span>Tools/Equipments</span>
        </div>
    </div>
</div>

<div class="row">
    @foreach ($generalInformation->toolsEquipment->equipmentInformation as $index => $toolsEquipment)
        <div class="col-md-6">
            <div class="tools-card">
                <div class="card-body">
                    <div class="row mb-4">
                        <h4 class="tools-title">Tools/Equipment Information #{{ $index + 1 }}</h4>
                    </div>

                    <div class="tools-info">
                        <div class="row">
                            <div class="col-6">
                                <b>Equipment:</b> {{ $toolsEquipment->equipment }}
                            </div>
                            <div class="col-6">
                                <b>Year:</b> {{ $toolsEquipment->year }}
                            </div>
                        </div>
                    </div>

                    <div class="tools-info">
                        <div class="row">
                            <div class="col-6">
                                <b>Make:</b> {{ $toolsEquipment->make }}
                            </div>
                            <div class="col-6">
                                <b>Model:</b> {{ $toolsEquipment->model }}
                            </div>
                        </div>
                    </div>

                    <div class="tools-info">
                        <div class="row">
                            <div class="col-6">
                                <b>Value:</b> {{ $toolsEquipment->value }}
                            </div>
                            <div class="col-6">
                                <b>Year Acquired:</b> {{ $toolsEquipment->year_acquired }}
                            </div>
                        </div>
                    </div>

                    <div class="tools-info">
                        <div class="row">
                            <div class="col-12">
                                <b>Serial Identification Number:</b> {{ $toolsEquipment->serial_identification_no }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-calendar-event-line title-icon"></i>
            <span>Previous Tools Equipment Information</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Expiration of Tools Equipment:</span>
                    <span class="data-value">
                        {{ \Carbon\Carbon::parse($generalInformation->lead->toolsEquipmentExpirationProduct->expiration_date)->format('M-j-Y') }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Prior Carrier:</span>
                    <span
                        class="data-value">{{ $generalInformation->lead->toolsEquipmentExpirationProduct->prior_carrier }}</span>
                </div>
            </div>
        </div>
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

        $('.sendAppointedToolsEquipmentForQuotation').on('click', function() {

            var id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to send this product for quotation',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('change-appointed-product-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            id: id,
                            status: 7
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Product Request For Quotation',
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });

        });

        $('.sendOutToolsEquipmentQuotation').on('click', function() {
            var id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to send out this quotation',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('change-appointed-product-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            id: id,
                            status: 30
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Quotation Sent Out',
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    });
</script>
