<style>
    .wider-card {
        width: 100%;
        /* Set width to 100% to make it wider */
        max-width: 350px;
        /* Adjust the max-width as needed */
    }
</style>
<div class="card"
    style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4>{{ $leads->GeneralInformation->firstname . ' ' . $leads->GeneralInformation->lastname }}</h4>
                <div class="">
                    {{ $leads->GeneralInformation->job_position }}
                </div>
                <div class="">
                    {{ $leads->company_name }}
                </div>
                <div class="">
                    {{ $leads->GeneralInformation->email_address }}
                </div>
                <div>
                    <b>{{ $leads->tel_num }}</b>
                </div>
            </div>

            <div class="card wider-card"
                style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 10px;">
                <div class="card-body" style="text-align: center;">
                    <h6 style="margin-bottom: 10px;">Change Status:</h6>
                    <div class="form-group" style="margin-bottom: 10px;">
                        <select class="form-control select2-search-disable" id="statusSelect"
                            style="border: 1px solid #ccc; border-radius: 4px; padding: 6px;">
                            @if ($product->status == 3 || $product->status == 4 || $product->status == 5)
                                <option value="3" @if ($product->status == 3) selected @endif>
                                    Pending
                                </option>
                                <option value="4" @if ($product->status == 4) selected @endif>
                                    Follow
                                    Up</option>
                                <option value="5" @if ($product->status == 5) selected @endif>
                                    Declined</option>
                            @endif
                            @if ($product->status == 11)
                                <option value="11" @if ($product->status == 11) selected @endif>
                                    Bound</option>
                            @endif
                            @if ($product->status == 9)
                                <option value="9" @if ($product->status == 9) selected @endif>
                                    Make A Payment</option>
                            @endif
                            @if ($product->status == 10 || $product->status == 6)
                                <option value="6" @if ($product->status == 6) selected @endif>
                                    Request To Bind</option>
                                <option value="10" @if ($product->status == 10) selected @endif>
                                    Payment Approved</option>
                            @endif
                            @if ($product->status == 13)
                                <option value="13" @if ($product->status == 13) selected @endif>
                                    Payment Declined</option>
                            @endif
                            @if ($product->status == 14)
                                <option value="14" @if ($product->status == 14) selected @endif>
                                    Binding Declined</option>
                                <option value="15" @if ($product->status == 15) selected @endif>
                                    Resend RTB</option>
                            @endif
                            @if ($product->status == 15)
                                <option value="15" @if ($product->status == 15) selected @endif>
                                    Resend RTB</option>
                            @endif
                            @if ($product->status == 22)
                                <option value="22" @if ($product->status == 22) selected @endif>
                                    Pending</option>
                            @endif
                            @if ($product->status == 12)
                                <option value="22" @if ($product->status == 12) selected @endif>
                                    Binding</option>
                            @endif
                        </select>
                    </div>
                    @if ($product->status == 14 || $product->status == 10 || $product->status == 6 || $product->status == 15)
                        <button type="button" class="btn btn-success waves-effect waves-light"
                            style="padding: 6px 12px; font-size: 14px;" id="saveStatusButton">Submit</button>
                    @endif
                </div>
            </div>

            <div class="d-flex">
                <div class="mr-2" style="margin-right: .5rem">
                    <button class="btn btn-outline-primary waves-effect waves-light btn-lg btnEdit"
                        id="editGeneralInformationButton" name="edit" type="button">EDIT</button>
                </div>
                <div class="mr-2" style="margin-right: .5rem">
                    <button
                        class="btn btn-outline-success waves-effect waves-light
                        btn-lg addProductButton"
                        id="addProductButton" name="addProduct" type="button">ADD PRODUCT</button>

                </div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-0" role="tablist" style="margin-top: 1rem">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#summary" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">
                        Summary
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#product" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">
                        {{ $product->product }} Information
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">History Log</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">Quotation</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                    <h5><i class="ri-file-edit-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#accounting" role="tab">
                    <h5><i class="ri-hand-coin-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#financingAgreement" role="tab">
                    <h5><i class="ri-file-shield-2-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#bindingDocs" role="tab">
                    <h5>binding docs</h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#emails" role="tab">
                    <h5><i class="ri-mail-send-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab">
                    <h5><i class="ri-folders-line"></i></h5>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editGeneralInformationButton').on('click', function() {
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


    });
</script>
