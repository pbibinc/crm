<div class="modal fade" id="policyCancellationModal" tabindex="-1" aria-labelledby="policyCancellationModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="policyCancellationModalTitle">Cancellation Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="cancellationForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="typeOfCancellationDropdown">Type of Cancellation:</label>
                            <select name="typeOfCancellationDropdown" id="typeOfCancellationDropdown"
                                class="form-select">
                                <option value="">Select Type of Cancellation</option>
                                <option value="Requested by Customer">Requested by Customer</option>
                                <option value="Non-Payment">Non-Payment</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="isIntent">Is Intent:</label>
                            <div class="form-check form-switch mb-3" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="isIntent">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="typeOfAction">Action Type</label>
                            <select name="typeOfAction" id="typeOfAction" class="form-select">
                                <option value="">Select Action Type</option>
                                <option value="Reinstate">Reinstate</option>
                                {{-- <option value="Request For Cancellation">Request For Cancellation </option> --}}
                                <option value="Subject For Rewrite">Subject For Rewrite</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6" id="reinstateDateDiv" hidden>
                            <label for="reinstatedDate" id="reinstatedDateLabel">Reinstated Date</label>
                            <input type="date" class="form-control" name="reinstatedDate" id="reinstatedDate">
                        </div>
                        <div class="col-6">
                            <label for="reinstatedEligibilityDate" id="reinstatedEligibilityDateLabel" hidden>Reinstated
                                Eligibility Date</label>
                            <input type="date" class="form-control" name="reinstatedEligibilityDate"
                                id="reinstatedEligibilityDate" hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="agentRemakrs">Agent Remarks:</label>
                        <div>
                            <textarea name="agentRemakrs" id="agentRemakrs" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label for="recoveryAction">Recovery Action:</label>
                        <div>
                            <textarea name="recoveryAction" id="recoveryAction" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="policyId" id="cancelleationPolicyId">
                    <input type="hidden" name="intent" id="intent">
                    <input type="hidden" name="action" id="action">
                    <input type="hidden" name="requestForCancellation" id="requestForCancellation">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <button class="btn btn-warning" id="submitForRewrite">Subject For Rewrite</button> --}}
                    <input type="submit" class="btn btn-success waves-effect waves-light" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cancellationForm').on('submit', function(e) {
            e.preventDefault();
            var action = $('#action').val();
            var typeOfAction = $('#typeOfAction').val();
            var id = $('#cancelleationPolicyId').val();
            var url = action == 'edit' ? `{{ route('cancellation-report.update', ':id') }}` :
                "{{ route('cancellation-report.store') }}";
            var method = action == 'edit' ? 'PUT' : 'POST';
            if (action == 'edit') {
                url = url.replace(':id', id);
            }
            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Policy has been cancelled!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#policyCancellationModal').modal('hide');
                            location.reaload();
                        }
                    });
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                    });
                }
            });
        });

        $('#policyCancellationModal').on('hide.bs.modal', function() {
            console.log('modal closed');
            $('#typeOfCancellationDropdown').val('');
            $('#reinstatedDate').val('');
            $('#reinstatedEligibilityDate').val('');
            $('#agentRemakrs').val(''); // Make sure the ID here is correct
            $('#recoveryAction').val(' ');
            $('#cancellationPolicyId').val(''); // Make sure the ID here is correct
        });

        $('#isIntent').on('change', function() {
            if ($(this).is(':checked')) {
                $('#intent').val('1');
                $('input[name="reinstatedDate"]').attr('hidden', false);
                $('input[name="reinstatedEligibilityDate"]').attr('hidden', false);
                $('#reinstatedDateLabel').attr('hidden', false);
                $('#reinstatedEligibilityDateLabel').attr('hidden', false);
            } else {
                $('#intent').val('0');
                $('input[name="reinstatedDate"]').attr('hidden', true);
                $('input[name="reinstatedEligibilityDate"]').attr('hidden', true);
                $('#reinstatedDateLabel').attr('hidden', true);
                $('#reinstatedEligibilityDateLabel').attr('hidden', true);

            }
        });

        $('#isRequestForCancellation').on('change', function() {
            if ($(this).is(':checked')) {
                $('#requestForCancellation').val('1');
            } else {
                $('#requestForCancellation').val('0');
            }
        });

        $('#submitForRewrite').on('click', function(e) {
            e.preventDefault();
            var id = $('#cancelleationPolicyId').val();
            var action = $('#action').val();
            var url = action == 'edit' ? `{{ route('cancellation-report.update', ':id') }}` :
                "{{ route('cancellation-report.store') }}";
            var method = action == 'edit' ? 'PUT' : 'POST';
            if (action == 'edit') {
                url = url.replace(':id', id);
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to submit this policy for rewrite!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: method,
                        data: $('#cancellationForm').serialize(),
                        success: function(data) {
                            var changeStatusUrl =
                                `{{ route('change-policy-status', ':id') }}`
                                .replace(':id', id);
                            $.ajax({
                                url: changeStatusUrl,
                                method: 'POST',
                                data: {
                                    status: 'Subject For Rewrite'
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Submitted!',
                                        'Policy has been submitted for rewrite.',
                                        'success'
                                    ).then((result) => {
                                        if (result
                                            .isConfirmed
                                        ) {
                                            $('#policyCancellationModal')
                                                .modal(
                                                    'hide'
                                                );
                                            location
                                                .reload();
                                        }
                                    });
                                },
                                error: function(data) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Something went wrong!',
                                    });
                                }
                            });
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!',
                            });
                        }
                    });

                }
            });

        });

        $('#typeOfAction').on('change', function() {
            if ($(this).val() == 'Reinstate') {
                $('#reinstateDateDiv').attr('hidden', false);
                $('#reinstatedDate').attr('required', true);
            } else {
                $('#reinstateDateDiv').attr('hidden', true);
                $('#reinstatedDate').attr('required', false);
                $('#reinstatedDate').val('');
            }
        });

    });
</script>
