@extends('admin.admin_master')
@section('admin')
    <style>
        .feedback-message {
            font-size: 1.1em;
            margin-top: 0.5em;
        }
    </style>
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                {{-- Single Email Validator Container --}}
                <div class="card">
                    <div class="card-body" id="batchEmailValidatorContainer">
                        <h4 class="card-title">Batch Email Validation
                            <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-original-title="Batch email validations by comma separated emails."></i>
                        </h4>
                        <p class="card-title-desc" id="creditBalance">Type your email you want to validate below.
                            <mark>Remaining Credits: </mark>
                        </p>
                        <form class="mt-4" id="batchEmailValidatorForm" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="emailAddresses" class="form-label">Email Address</label>
                                        <input type="text" name="emailAddresses[]" id="emailAddresses"
                                            class="form-control" placeholder="Ex. johndoe@example.com, janedoe@example.com"
                                            value="" required />
                                        <div id="validationFeedback" class="feedback-message"></div>
                                        <!-- Placeholder for feedback -->
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" name="validate_emails" id="validate_emails"
                                    class="btn btn-primary ladda-button" data-style="expand-right">
                                    Validate Emails
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ladda Library CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css">

    {{-- Ladda Library JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>

    {{-- Validate Email Process --}}
    <script>
        $(document).ready(function() {
            var laddaButton = Ladda.create(document.querySelector('#validate_emails'));

            $(document).on('submit', '#batchEmailValidatorForm', function(e) {
                e.preventDefault();
                laddaButton.start();

                // Get the email addresses from the input field
                var emailInput = $('#emailAddresses').val();

                // Split the email string by commas, trim spaces, and create an array of objects with email and IP addresses
                var emailsArray = emailInput.split(',').map(function(email) {
                    return {
                        email_address: email.trim()
                    };
                });

                // console.log(emailsArray);

                // Create the final object to send
                var emailData = {
                    email_batch: emailsArray // The correct format for the API
                };

                // Send the email data to the server
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ route('batch-email-validator.process') }}",
                    dataType: "json",
                    contentType: "application/json",
                    processData: false,
                    data: JSON.stringify(emailData),
                    success: function(response) {
                        laddaButton.stop();

                        $('#validationFeedback').empty();

                        // Clear previous feedback and classes
                        // $('#emailAddresses').removeClass('is-valid is-invalid');
                        // $('#validationFeedback').empty().removeClass(
                        //     'text-success text-danger text-warning');

                        if (response.status === 'success') {
                            var results = response.data;
                            // Loop through each email result and display the status and explanation
                            results.forEach(function(result) {
                                $('#validationFeedback').append(`
                                    <p><strong>Email:</strong> ${result.email}</p>
                                    <p><strong>Status:</strong> ${result.status}</p>
                                    <p><strong>Explanation:</strong> ${result.explanation}</p>
                                    <hr>
                                `);
                            });
                            // var status = response.data.status;
                            // var explanation = response.data.explanation;

                            // switch (status) {
                            //     case 'valid':
                            //     case 'alias_address':
                            //     case 'leading_period_removed':
                            //     case 'alternate':
                            //         $('#emailAddress').addClass('is-valid');
                            //         $('#validationFeedback').addClass('text-success').text(
                            //             explanation);
                            //         break;

                            //     case 'invalid':
                            //     case 'does_not_accept_mail':
                            //     case 'failed_syntax_check':
                            //     case 'mailbox_quota_exceeded':
                            //     case 'mailbox_not_found':
                            //     case 'no_dns_entries':
                            //     case 'possible_typo':
                            //     case 'unroutable_ip_address':
                            //         $('#emailAddress').addClass('is-invalid');
                            //         $('#validationFeedback').addClass('text-danger').text(
                            //             explanation);
                            //         break;

                            //     case 'do_not_mail':
                            //     case 'global_suppression':
                            //     case 'possible_trap':
                            //     case 'role_based':
                            //     case 'role_based_catch_all':
                            //     case 'disposable':
                            //     case 'toxic':
                            //         $('#emailAddress').addClass('is-invalid');
                            //         $('#validationFeedback').addClass('text-danger').text(
                            //             explanation);
                            //         break;

                            //     case 'unknown':
                            //     case 'antispam_system':
                            //     case 'exception_occurred':
                            //     case 'failed_smtp_connection':
                            //     case 'forcible_disconnect':
                            //     case 'greylisted':
                            //     case 'mail_server_did_not_respond':
                            //     case 'mail_server_temporary_error':
                            //     case 'timeout_exceeded':
                            //         $('#emailAddress').addClass('is-invalid');
                            //         $('#validationFeedback').addClass('text-warning').text(
                            //             explanation);
                            //         break;

                            //     default:
                            //         $('#validationFeedback').addClass('text-muted').text(
                            //             "Unknown email validation status.");
                            //         break;
                            // }
                        } else {
                            $('#validationFeedback').addClass('text-danger').text(response
                                .message);

                            // $('#emailAddress').addClass('is-invalid');
                            // $('#validationFeedback').addClass('text-danger').text(response
                            //     .message);
                        }
                    },
                    error: function(response) {
                        laddaButton.stop();
                        $('#emailAddresses').addClass('is-invalid');
                        $('#validationFeedback').addClass('text-danger').text(response
                            .responseJSON.message);
                    },
                    complete: function() {
                        laddaButton.stop();
                    }
                });
            });

            getCreditBalance();
        });

        function getCreditBalance() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: "{{ route('zerobounce-credit-balance') }}",
                success: function(response) {
                    if (response.status === 'success') {
                        var credits = response.credits;

                        // Convert credits to a number
                        credits = parseFloat(credits);

                        if (!isNaN(credits)) {
                            // Format the number with commas and without decimal places
                            var formattedCredits = credits.toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0,
                            });
                            $('#creditBalance').find('mark').text(
                                `Remaining Balance: ${formattedCredits}`);
                        } else {
                            $('#creditBalance').find('mark').text(
                                `Remaining Balance: N/A`);
                        }
                    }
                },
                error: function(error, textStatus, jqXHR) {
                    console.log('AJAX error:', error);
                    console.log('Text status:', textStatus);
                    console.log('jqXHR:', jqXHR);
                }
            });
        }
    </script>
@endsection
