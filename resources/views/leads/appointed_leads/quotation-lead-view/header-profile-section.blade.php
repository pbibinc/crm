<div class="card"
    style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div style="font-size: 14px;">
                <h5 style="margin-bottom: 5px;">
                    {{ $leads->GeneralInformation->firstname . ' ' . $leads->GeneralInformation->lastname }}</h5>
                <div>{{ $leads->GeneralInformation->job_position }}</div>
                <div>{{ $leads->company_name }}</div>
                <div>{{ $leads->GeneralInformation->email_address }}</div>
                <div><b>{{ $leads->tel_num }}</b></div>
            </div>
            <div class="d-flex">
                {{-- <div class="mr-2" style="margin-right: .5rem">
                    <button class="btn btn-outline-primary waves-effect waves-light btn-lg btnEdit"
                        id="editGeneralInformationButton" name="edit" type="button">EDIT</button>
                </div> --}}
                {{-- <div class="mr-2" style="margin-right: .5rem">
                    <button
                        class="btn btn-outline-success waves-effect waves-light
                    btn-lg callButton"
                        name="edit" type="button">CALL</button>
                </div>
                <div class="" style="margin-right: .5rem">
                    <button
                        class="btn btn-outline-success waves-effect waves-light
                    btn-lg callButton"
                        name="edit" type="button">CALL</button>
                </div>
                <div class="">
                    <button
                        class="btn btn-outline-success waves-effect waves-light
                    btn-lg callButton"
                        name="edit" type="button">CALL</button>
                </div> --}}
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-0" role="tablist" style="margin-top: 0.5rem">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#summary" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    Overview
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#product" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    Client Info
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    Quote Products
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    History Log
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-file-edit-line"></i></h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#emails" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-mail-send-line"></i></h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-folders-line"></i></h6>
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
    });
</script>
