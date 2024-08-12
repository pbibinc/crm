@php
    use App\Models\QuotationProduct;
@endphp
<style>
    #cd-timeline {
        max-height: 500px;
        /* Adjust the max height as needed */
        overflow-y: auto;
    }

    .cd-timeline-inner {
        padding: 10px;
        /* Add padding to the inner container */
    }
</style>
<section id="cd-timeline" class="cd-container">
    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-success">
            <i class="mdi mdi-cloud-upload"></i>
        </div>
        <div class="cd-timeline-content">
            <p class="mb-0 text-muted font-14">Leads Has been uploaded.</p>
            <span
                class="cd-date">{{ \Carbon\Carbon::parse($generalInformation->lead->created_at)->format('M-j-Y g:iA') }}</span>
        </div>

    </div>
    @foreach ($generalInformation->lead->leadHistories as $leadHistory)
        <div class="cd-timeline-block">
            @php
                $changes = json_decode($leadHistory->changes);
            @endphp
            @if (isset($changes->assigned_at))
                <div class="cd-timeline-img cd-success">
                    <i class="mdi mdi-account-arrow-left"></i>
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Assigned to: {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->assigned_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif (isset($changes->reassigned_at))
                <div class="cd-timeline-img cd-success">
                    <i class="mdi mdi-account-arrow-right"></i>
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Reassigned to: {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->reassigned_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif(isset($changes->old_owner_name))
                @php
                    $product = QuotationProduct::find($changes->product_id);
                @endphp
                <div class="cd-timeline-img cd-success">
                    <i class="mdi mdi-account-arrow-right"></i>
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">{{ $product->product }} Reassigned to:
                        {{ $changes->new_owner_name }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($leadHistory->created_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif (isset($changes->appointed_by))
                <div class="cd-timeline-img cd-success">
                    {{-- <i class="mdi mdi-book-edit"></i> --}}
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Application Taken by:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->appointed_by)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif(isset($changes->assign_appointed_at))
                @php
                    $product = $leadHistory->getProductByProductId($changes->product_id);
                @endphp
                <div class="cd-timeline-img">
                    {{-- <i class="mdi mdi-book-edit"></i> --}}
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-1 mt-0 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14"> {{ $product->product }} Has Been assigned to:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->assign_appointed_at)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif(isset($changes->type) && $changes->type == 'renewal_reminder')
                <div class="cd-timeline-img cd-success">
                    {{-- <i class="mdi mdi-book-edit"></i> --}}
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">Renewal Reminder Sent By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span class="cd-date">{{ \Carbon\Carbon::parse($changes->sent_date)->format('M-j-Y g:iA') }}</span>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'general-information-update')
                <div class="cd-timeline-img cd-success">
                    {{-- <i class="mdi mdi-book-edit"></i> --}}
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14">General Information Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>

                    <ul>
                        @foreach ($changes->changes as $field => $change)
                            @php
                                // Check if the field is an amount field
                                $isAmountField = in_array($field, [
                                    'gross_receipt',
                                    'employee_payroll',
                                    'owners_payroll',
                                    'sub_out',
                                    'material_cost',
                                ]);
                            @endphp
                            <li>
                                <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong>
                                Changed from
                                @if ($isAmountField)
                                    ${{ number_format($change->old, 2) }}
                                @else
                                    {{ $change->old }}
                                @endif
                                to
                                @if ($isAmountField)
                                    ${{ number_format($change->new, 2) }}
                                @else
                                    {{ $change->new }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'general-liabilities-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">General Liability Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton" value="{{ $leadHistory->id }}"
                            id="{{ $leadHistory->lead_id }}" form="general-liabilities-form">View
                            Changes</button>
                    </p>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'workers-compensation-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">Workers Compensation Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton" value="{{ $leadHistory->id }}"
                            id="{{ $leadHistory->lead_id }}" form="workers-compensation-form">View
                            Changes</button>
                    </p>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'commercial-auto-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">Commercial Auto Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton" value="{{ $leadHistory->id }}"
                            id="{{ $leadHistory->lead_id }}" form="commercial-auto-form">View
                            Changes</button>
                    </p>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'excess-liability-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">Excess Liability Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton" value="{{ $leadHistory->id }}"
                            id="{{ $leadHistory->lead_id }}" form="excess-liability-form">View
                            Changes</button>
                    </p>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'tools-equipment-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">Tools Equipment Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton"
                            value="{{ $leadHistory->id }}" id="{{ $leadHistory->lead_id }}"
                            form="tools-equipment-form">View
                            Changes</button>
                    </p>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'builders-risk-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">Builders Risk Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton"
                            value="{{ $leadHistory->id }}" id="{{ $leadHistory->lead_id }}"
                            form="builders-risk-form">View
                            Changes</button>
                    </p>
                </div>
            @elseif(isset($changes->changes) && $changes->type == 'business-owners-policy-update')
                <div class="cd-timeline-img cd-success">
                    <img src="{{ asset($leadHistory->userProfile->media->filepath) }}"
                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                </div>
                <div class="cd-timeline-content">
                    <p class="mb-0 text-muted font-14 mb-3">Business Owners Policy Updated By:
                        {{ $leadHistory->userProfile->fullName() }}.</p>
                    <span
                        class="cd-date ">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                    <p>
                        <button class="btn btn-sm btn-outline-primary viewChangesButton"
                            value="{{ $leadHistory->id }}" id="{{ $leadHistory->lead_id }}"
                            form="business-owners-form">View
                            Changes</button>
                    </p>
                </div>
            @endif
        </div>
    @endforeach
</section>
<script>
    $(document).ready(function() {
        $('.viewChangesButton').on('click', function(e) {
            e.preventDefault();
            var activityId = $(this).val();
            var id = $(this).attr('id');
            var form = $(this).attr('form');
            var url = "{{ env('APP_FORM_URL') }}";
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: id,
                    activityId: activityId
                },
            });
            window.open(`${url}${form}/previous-product-information`, "s_blank",
                "width=1000,height=849")
        });
    });
</script>
