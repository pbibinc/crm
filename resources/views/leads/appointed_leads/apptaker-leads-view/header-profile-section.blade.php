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
            <div class="d-flex">
                <div class="mr-2" style="margin-right: .5rem">
                    <button class="btn btn-outline-primary waves-effect waves-light btn-lg btnEdit"
                        id="editGeneralInformationButton" name="edit" type="button">EDIT</button>
                </div>
                <div class="mr-2" style="margin-right: .5rem">
                    <button
                        class="btn btn-outline-success waves-effect waves-light
                    btn-lg addProductButton"
                        id="addProductButton" name="edit" type="button">ADD PRODUCT</button>
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
                        Product
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">History Log</span>
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

        $('#addProductButton').on('click', function() {});
    });
</script>
