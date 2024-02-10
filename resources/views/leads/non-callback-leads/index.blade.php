@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">

            <div class="row">
                <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body">
                        <h5>Other Leads</h5>
                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="otherDispositionnTable">
                            <thead style="background-color: #f0f0f0;">
                                <th>Company Name</th>
                                <th>Disposition</th>
                                <th>Tel Num</th>
                                <th>Class Code</th>
                                <th>State</th>
                                <th>Set Disposition At</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!--Modal for No Answer Disposition-->
            <div class="modal fade bs-example-modal-center" id="transactionModal" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dispositionModalTitle">Test</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Disposition</label>
                                        <select name="timezone" id="dispositionDropDown" class="form-control">
                                            <option value="">Select Disposition</option>
                                            <option value="">ALL</option>
                                            @foreach ($dispositions as $disposition)
                                                <option value="{{ $disposition->id }}">{{ $disposition->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <label id='callBackDateLabel'>Date Time</label>
                                <div>
                                    <input class="form-control" type="datetime-local" id="callBackDateTime"
                                        name="callBackDateTime">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label>Remarks</label>
                                <div>
                                    <textarea required class="form-control" rows="5" id="callBackRemarks"></textarea>
                                </div>
                            </div>
                            <input type="hidden" id="callBackIdHiddenInput">
                            <input type="hidden" id="leadsIdHiddenInput">
                            <input type="hidden" id="remarksHiddenInput">
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-success waves-effect waves-light callbackDispoSubmitButton"
                                id="callbackDispoSubmitButton">Submit</button>
                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            {{-- end for modal transaction --}}

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#otherDispositionnTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('other-dispositions-data') }}",
                    'beforeSend': function(request) {
                        request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
                    }
                },
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    }, {
                        data: 'disposition',
                        name: 'disposition'
                    },
                    {
                        data: 'tel_num',
                        name: 'tel_num'
                    },
                    {
                        data: 'class_code',
                        name: 'class_code'
                    },
                    {
                        data: 'state_abbr',
                        name: 'state_abbr'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }

                ],
                order: [
                    [5, 'desc']
                ],
            });
            $(document).on('click', '#companyLink', function(e) {
                var leadsId = $(this).data('id');
                var date = $(this).data('date');
                var remarksData = $(this).data('remarks');
                var remarksId = $(this).data('remarksid');
                var name = $(this).data('name');
                var callbackId = $(this).data('callbackid');
                var type = $(this).data('type');

                $('#transactionModal').modal('show');
                $('#callBackRemarks').val(remarksData);
                $('#callBackDateTime').val(date);
                $('#dispositionModalTitle').text(name);
                $('#dispositionDropDown').val(type);
                $('#callBackIdHiddenInput').val(callbackId);
                $('#leadsIdHiddenInput').val(leadsId);
                $('#remarksHiddenInput').val(remarksId);

                if (type == 2 || type == 6 ||
                    type == 11 || type == 12) {
                    $('#callBackDateTime').show();
                    $('#callBackDateLabel').show();
                } else {
                    $('#callBackDateLabel').hide();
                    $('#callBackDateTime').hide();
                };

                $('#dispositionDropDown').on('change', function(e) {
                    e.preventDefault();
                    var dropdownId = $(this).attr('id');
                    var rowId = dropdownId.replace('dispositionDropDown', '');
                    var selectedDisposition = $(this).val();
                    if (selectedDisposition == 2 || selectedDisposition == 6 ||
                        selectedDisposition == 11 || selectedDisposition == 12) {
                        $('#callBackDateTime').show();
                        $('#callBackDateLabel').show();
                    } else {
                        $('#callBackDateLabel').hide();
                        $('#callBackDateTime').hide();
                    };
                    var url = "{{ env('APP_FORM_URL') }}";
                    if (selectedDisposition == '1') {
                        $.ajax({
                            url: "{{ route('list-lead-id') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            dataType: 'json',
                            method: 'POST',
                            data: {
                                leadId: leadsId
                            },
                            success: function(response) {
                                $('#otherDispositionnTable').DataTable().ajax.reload();


                            },
                            error: function(response) {
                                alert('error');
                            }
                        });
                        window.open(`${url}/appoinnted-lead-questionare`, "s_blank",
                            "width=1000,height=849");
                        $('#transactionModal').modal('hide');;
                    } else if (selectedDisposition !== '2' && selectedDisposition !== "6" &&
                        selectedDisposition !==
                        "11" && selectedDisposition !== "12") {
                        $('#callBackDateTime').hide();
                        $('#callBackDateTime').val(null);
                        $('#callBackDateLabel').hide();
                    };
                });
                $('#callbackDispoSubmitButton').on('click', function(e) {
                    e.preventDefault();
                    var callBackRemarks = $('#callBackRemarks').val();
                    var dateTime = $('#callBackDateTime').val();
                    var selectedDisposition = $('#dispositionDropDown').val();
                    var callBackInputId = $('#callBackIdHiddenInput').val();
                    var leadsId = $('#leadsIdHiddenInput').val();
                    var remarksId = $('#remarksHiddenInput').val();
                    if (selectedDisposition == 2 || selectedDisposition == 6 ||
                        selectedDisposition == 11 || selectedDisposition == 12) {
                        if (callBackInputId == 0) {
                            $.ajax({
                                url: "{{ route('call-back.store') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                dataType: 'json',
                                method: 'POST',
                                data: {
                                    type: selectedDisposition,
                                    dateTime: dateTime,
                                    callBackRemarks: callBackRemarks,
                                    leadId: leadsId,
                                    status: 1
                                },
                                success: function(response) {
                                    $('#transactionModal').modal('hide');
                                    $('#otherDispositionnTable').DataTable().ajax
                                        .reload();

                                    $.ajax({
                                        url: "{{ route('non-call-back.destroy', ':id') }}"
                                            .replace(':id',
                                                remarksId),
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]')
                                                .attr('content')
                                        },
                                        dataType: 'json',
                                        method: 'POST',
                                        data: {
                                            dispositionId: selectedDisposition,
                                            remarksId: remarksId,
                                            callBackRemarks: callBackRemarks,
                                            leadId: leadsId
                                        },
                                        success: function(response) {
                                            $('#callBackToday').DataTable()
                                                .ajax
                                                .reload();
                                            $('#callBackLeadsTable')
                                                .DataTable().ajax
                                                .reload();

                                        }
                                    });
                                },
                                error: function(response) {
                                    alert('error');
                                }
                            });


                        } else {
                            $.ajax({
                                url: "{{ route('call-back.update', ':id') }}"
                                    .replace(':id',
                                        callBackInputId),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                dataType: 'json',
                                method: 'PUT',
                                data: {
                                    dispositionId: selectedDisposition,
                                    dateTime: dateTime,
                                    callBackRemarks: callBackRemarks,
                                    leadId: leadsId,
                                    status: 1
                                },
                                success: function(response) {
                                    $('#transactionModal').modal('hide');
                                    $('#otherDispositionnTable').DataTable().ajax
                                        .reload();

                                },
                                error: function(response) {
                                    alert('error');
                                }
                            });
                        }
                    } else {
                        if (remarksId == 0) {
                            $.ajax({
                                url: "{{ route('delete-callback-disposition', ':id') }}"
                                    .replace(':id',
                                        callBackInputId),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                dataType: 'json',
                                method: 'POST',
                                data: {
                                    leadId: leadsId,
                                    dispositionId: selectedDisposition,
                                },
                                success: function(response) {
                                    $('#transactionModal').modal('hide');
                                    $('#otherDispositionnTable').DataTable().ajax
                                        .reload();

                                },
                                error: function(response) {
                                    alert('error');
                                }
                            });
                            $.ajax({
                                url: "{{ route('assign-remark-leads') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                dataType: 'json',
                                method: 'POST',
                                data: {
                                    dispositionId: selectedDisposition,
                                    remarks: callBackRemarks,
                                    leadId: leadsId,
                                },
                                success: function(response) {
                                    $('#transactionModal').modal('hide');
                                    $('#otherDispositionnTable').DataTable().ajax
                                        .reload();

                                },
                                error: function(response) {
                                    alert('error');
                                }
                            });
                        } else {
                            $.ajax({
                                url: "{{ route('update-non-callback-dispositions', ':id') }}"
                                    .replace(':id',
                                        remarksId),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                dataType: 'json',
                                method: 'PUT',
                                data: {
                                    dispositionId: selectedDisposition,
                                    remarksId: remarksId,
                                    callBackRemarks: callBackRemarks,
                                    leadId: leadsId
                                },
                                success: function(response) {
                                    $('#transactionModal').modal('hide');
                                    $('#otherDispositionnTable').DataTable().ajax
                                        .reload();



                                }
                            });
                        }


                    }
                });
            });
        })
    </script>
@endsection
