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
{{-- @if ($actionButtons == true)
    <div class="row mb-4">
        <div class="col-md-6">
            <button type="button" class="editBusinessOwnersPolicy btn btn-primary"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif --}}
@php
    $businessOwnersProduct = $generalInformation->lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
        'Business Owners',
        $generalInformation->lead->quoteLead->QuoteInformation->id,
    );
@endphp
<div class="row-title">
    <div class="card-title d-flex align-items-center">
        <h5 class="mb-0 me-2">Business Owners Profile</h5>
        @if ($businessOwnersProduct->status == 5)
            <span class="badge bg-danger align-middle">Declined</span>
        @endif
    </div>
    <div>
        @if ($actionButtons == true)
            <button type="button" class="editBusinessOwnersPolicy btn btn-light btn-sm waves-effect waves-light"
                value="{{ $generalInformation->lead->id }}">
                <i class="ri-edit-line"></i> Edit
            </button>
        @endif
        @if ($businessOwnersProduct->status == 29)
            <button type="button"
                class="sendAppointedBusinessOwnersForQuotation btn btn-success btn-sm waves-effect waves-light"
                value="{{ $businessOwnersProduct->id }}">
                <i class="ri-task-line"></i> Send For Quotation
            </button>
        @elseif($businessOwnersProduct->status == 1)
            <button type="button"
                class="sendOutBusinessOwnersQuotation btn btn-success btn-sm waves-effect waves-light"
                value="{{ $businessOwnersProduct->id }}">
                <i class="ri-task-line"></i> Send Out Quotation</button>
        @elseif($businessOwnersProduct->status == 5)
            <button type="button"
                class="sendAppointedBusinessOwnersForQuotation btn btn-warning btn-sm waves-effect waves-light"
                value="{{ $businessOwnersProduct->id }}">Resend For Quotation</button>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-suitcase-line title-icon"></i>
            <span>Business Owners Information</span>
        </div>

        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Property Address:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->property_address }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Loss Payee:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->loss_payee_information }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Building Industry:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->building_industry }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Occupancy:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->occupancy }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Building Cost:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->building_cost }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Construction Type:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->business_property_limit }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Year Built:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->year_built }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Square Footage:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->square_footage }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Number of Floors:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->floor_number }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Automatic Sprinkler System:</span>
                    <span
                        class="data-value">{{ $generalInformation->businessOwners->automatic_sprinkler_system }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Automatic Fire Alarm:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->automatic_fire_alarm }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Commercial Cooking System:</span>
                    <span
                        class="data-value">{{ $generalInformation->businessOwners->commercial_coocking_system }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Nearest Fire Hydrant:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->nereast_fire_hydrant }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Nearest Fire Station:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->nearest_fire_station }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Automatic Bulgar Alarm:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->automatic_bulgar_alarm }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Security Camera:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->security_camera }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Amount Policy:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->amount_policy }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-building-2-line title-icon"></i>
            <span>Major Structure Information</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Last Year Roofing Update:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->last_update_roofing }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Last Year Heating Update:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->last_update_heating }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Last Year Plumbing Update:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->last_update_plumbing }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Last Year Electrical Update:</span>
                    <span class="data-value">{{ $generalInformation->businessOwners->last_update_electrical }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-calendar-event-line title-icon"></i>
            <span>Previous Business Owners Policy</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Expiration of Business Owners Policy:</span>
                    <span
                        class="data-value">{{ \Carbon\Carbon::parse($generalInformation->lead->businessOwnersExpirationProduct->expiration_date)->format('M-j-Y') }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Prior Carrier:</span>
                    <span
                        class="data-value">{{ $generalInformation->lead->businessOwnersExpirationProduct->prior_carrier }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.editBusinessOwnersPolicy').on('click', function(e) {
            e.preventDefault();
            var leadId = $(this).val();
            var url = "{{ env('APP_FORM_URL') }}";
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
            window.open(`${url}business-owners-policy-form/edit`, "s_blank",
                "width=1000,height=849")
        });

        $('.sendAppointedBusinessOwnersForQuotation').on('click', function(e) {
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

        $('.sendOutBusinessOwnersQuotation').on('click', function(e) {
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
        })
    });
</script>
