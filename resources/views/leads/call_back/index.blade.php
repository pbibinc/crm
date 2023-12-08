@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Scheduled Callbacks Overview</h3>
                        <table id="callBackLeadsTable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #f0f0f0;">
                                <tr>
                                    <th>Company Name</th>
                                    <th>Disposition</th>
                                    <th>Callback Date</th>
                                    <th>Tel Num</th>
                                    <th>Class Code</th>
                                    <th>State</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h3>Other Leads</h3>
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

            {{-- <!--Modal for Call Back Disposition-->
            <div class="modal fade bs-example-modal-center" id="callbackModal" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mySmallModalLabel">Call back</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="example-datetime-local-input" class="col-form-label">Date and
                                            time</label>
                                    </div>
                                    <div class="col-9">
                                        <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00"
                                            id="callBackDateTime" name="callBackDateTime">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label>Remarks</label>
                                    <div>
                                        <textarea required class="form-control" rows="5" id="callBackRemarks"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-success waves-effect waves-light callbackDispoSubmitButton"
                                id="callbackDispoSubmitButton">Submit</button>
                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--Modal for GateKeeper Disposition-->
            <div class="modal fade bs-example-modal-center" id="gateKeeperModal" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mySmallModalLabel">Call Back Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="example-datetime-local-input" class="col-form-label">Date and time</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00"
                                        id="callBackDateTime">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label>Remarks</label>
                                <div>
                                    <textarea required class="form-control" id="callBackRemarks" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-success waves-effect waves-light callbackDispoSubmitButton"
                                id="callbackDispoSubmitButton">Submit</button>
                            <button type="button" class="btn btn-light waves-effect"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--Modal for No Answer Disposition-->
            <div class="modal fade bs-example-modal-center" id="noAnswerCallBack" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mySmallModalLabel">Set Time When To Call Back</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="example-datetime-local-input" class="col-form-label">Date and time</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00"
                                        id="callBackDateTime">
                                </div>
                                <textarea name="" id="callBackRemarks" cols="30" rows="10" value="N/A" hidden></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-success waves-effect waves-light callbackDispoSubmitButton"
                                id="callbackDispoSubmitButton">Submit</button>
                            <button type="button" class="btn btn-light waves-effect"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal --> --}}

        </div>
    </div>


    <style>
        .past-due {
            color: red;
            /* Text color */
            background-color: #fdd;
            /* Background color */
        }

        /* Define styles for the 'warning' class */
        .warning {
            color: orange;
            /* Text color */
            background-color: yellow;
            /* Background color */
        }

        /* Define styles for the 'upcoming' class */
        .upcoming {
            color: green;
            /* Text color */
            background-color: #dfd;
            /* Background color */
        }
    </style>
    <script>
        $(document).ready(function() {
            // function getCurrentDateTime() {
            //     var now = new Date();
            //     var year = now.getFullYear();
            //     var month = ('0' + (now.getMonth() + 1)).slice(-2);
            //     var day = ('0' + now.getDate()).slice(-2);
            //     var hours = ('0' + now.getHours()).slice(-2);
            //     var minutes = ('0' + now.getMinutes()).slice(-2);
            //     var seconds = ('0' + now.getSeconds()).slice(-2);

            //     return year + '-' + month + '-' + day + 'T' + hours + ':' + minutes + ':' + seconds;
            // }

            // $('#callBackDateTime').val(getCurrentDateTime());

            $('#callBackLeadsTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: 300,
                scrollX: true,
                ajax: {
                    url: "{{ route('callback-lead') }}"
                },
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    }, {
                        data: 'disposition',
                        name: 'disposition'
                    },
                    {
                        data: 'date',
                        name: 'date'
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


                ],
                order: [
                    [2, 'asc']
                ],
                createdRow: function(row, data, dataIndex) {
                    // Get the date value from the data
                    var dateValue = data.date;

                    // Parse the date string into a Date object
                    var date = new Date(dateValue);

                    // Get the current date
                    var currentDate = new Date();

                    // Calculate the difference in days between the current date and the date in the row
                    var daysDifference = Math.floor((date - currentDate) / (1000 * 60 * 60 * 24));

                    // Add CSS classes based on date conditions
                    if (daysDifference < 0) {
                        $('td:eq(2)', row).addClass('past-due');

                    } else if (daysDifference >= 0 && daysDifference <= 7) {
                        $('td:eq(2)', row).addClass('warning');

                    } else {
                        $('td:eq(2)', row).addClass('upcoming');

                    }
                }
            });
            $('#otherDispositionnTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollY: 300,
                scrollX: true,
                ajax: {
                    url: "{{ route('other-dispositions-data') }}"
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
                                location.reload();
                            },
                            error: function(response) {
                                alert('error');
                            }
                        });
                        window.open(`${url}/appoinnted-lead-questionare`, "s_blank",
                            "width=1000,height=849");
                        $('#transactionModal').modal('hide');
                    } else if (selectedDisposition !== '2' && selectedDisposition !== "6" &&
                        selectedDisposition !==
                        "11" && selectedDisposition !== "12") {
                        $('#callBackDateTime').hide();
                        $('#callBackDateTime').val(null);
                        $('#callBackDateLabel').hide();
                    };
                });
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
                                location.reload();
                                $.ajax({
                                    url: "{{ route('non-call-back.destroy', ':id') }}"
                                        .replace(':id',
                                            remarksId),
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
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
                                        location.reload();
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
                                location.reload();
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
                                location.reload();
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
                                location.reload();
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
                                location.reload();
                            }
                        });
                    }


                }
            });
        });
    </script>
@endsection
