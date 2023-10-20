<h6>Business Owners Policy Quoation Form<i class="ri-information-fill"
        style="vertical-align: middle; color: #6c757d;"></i></h6>
<div class="card ">
    <div class="card-body">

        <div id="BopCompContainer"></div>

    </div>

</div>
<script>
    $(document).ready(function() {
        let quoteComparison;
        $.ajax({
            url: "{{ route('get-comparison-data') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "GET",
            data: {
                id: {{ $quoteProduct->id }}
            },
            success: function(data) {
                quoteComparison = data.quoteComparison;
                market = data.market;
                doSomethingWithQuoteComparison();
            },
            error: function() {
                console.log('error');
            }
        });

        function doSomethingWithQuoteComparison() {
            if (quoteComparison.length > 0) {
                $('.bopFirsCardForm').hide();
                quoteComparison.forEach(function(data) {
                    const marketObj = market.find(market => market.id === data.quotation_market_id);
                    const marketName = marketObj ? marketObj.name : 'Market Not Found';
                    let cardContent = `
            <div class="col-6">
                <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div style="display: flex; align-items: center;">
                              <h4 class="card-title">${marketName}</h4>
                              ${data.recommended === 1 ?  `<i class="mdi mdi-star" style="margin-left: 8px; margin-bottom: 6px;"></i>` : `` }
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label mt-2 fullPayment" >Full Payment: $${data.full_payment}</label>
                        </div>
                        <div class="col-6">
                            <label for="filterBy" class="form-label mt-2 downPayment">Down Payment: $${data.down_payment}</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label mt-2">Montly Payment: $${data.monthly_payment}</label>
                        </div>
                        <div class="col-6">
                            <div style="display: flex; align-items: center;">
                               <label for="filterBy" class="form-label mt-2">Fee:</label>
                               <input class="form-control brokerFee" id="brokerFee" style="margin-left: 10px;" type="text" value="${data.broker_fee}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">

                        </div>
                        <div class="col-8">

                        </div>
                    </div>
                    <input type="hidden" value="${data.id}" id="quoteComparisonId"/>
                <div class="row d-flex text-center">
                      <div class="col-12">
                        <div class="button-container">
                        <!-- Send Quotation Email Button -->
                                 <button type="button" class="btn btn-lg btn-primary waves-effect waves-light sendQuotationEmail  ladda-button" data-style="expand-right" data-toggle="tooltip" title="Send Quotation Email">
                                 <i class="ri-mail-send-line"></i> Send
                                 </button>

                                 <!-- Save Button -->
                                 <button type="button" class="btn btn-lg btn-success editBusinessOwnersFormButton" data-toggle="tooltip" title="Save Form">
                                 <i class="ri-save-line"></i> Save
                                 </button>
                        </div>
                     </div>
                    </div>
                </div>
            </div>

           `;
                    let lastRow = $('#BopCompContainer > .row:last-child');
                    if (lastRow.length == 0 || lastRow.children().length == 2) {
                        // Either no rows or the last row already has 2 cards, so create a new row
                        $('#BopCompContainer').append('<div class="row">' + cardContent + '</div>');
                    } else {
                        // Last row exists and only has 1 card, so append the new card there
                        lastRow.append(cardContent);
                    }
                    //    $('#BopCompContainer').append(cardContent);
                });

            }
        };

        $(document).on('focus', '.brokerFee', function() {
            // When the input gains focus, store its current value to data attribute
            let currentBrokerFee = parseFloat($(this).val()) || 0;
            $(this).data('lastBrokerFee', currentBrokerFee);
        });


        $(document).on('input', '.brokerFee', function() {
            // Get the parent card
            const card = $(this).closest('.card');

            // Get the current broker fee
            const currentBrokerFee = parseFloat($(this).val()) || 0;
            const lastBrokerFee = $(this).data('lastBrokerFee') || 0;

            // Find the related fullPayment and downPayment input fields within this card
            const fullPaymentLabel = card.find('.fullPayment');
            const downPaymentLabel = card.find('.downPayment');

            // Get their current values
            let fullPayment = parseFloat(fullPaymentLabel.text().split('$')[1]) || 0;
            let downPayment = parseFloat(downPaymentLabel.text().split('$')[1]) || 0;

            // Subtract last broker fee and add new broker fee
            fullPayment = fullPayment - lastBrokerFee + currentBrokerFee;
            downPayment = downPayment - lastBrokerFee + currentBrokerFee;

            // Update their values
            fullPaymentLabel.text(`$${fullPayment.toFixed(2)}`);
            downPaymentLabel.text(`$${downPayment.toFixed(2)}`);

            // Update the last broker fee for the next change
            $(this).data('lastBrokerFee', currentBrokerFee);

        });

        $(document).on('click', '.editBusinessOwnersFormButton', function() {
            var card = $(this).closest('.card');

            //form
            var market = card.find('.form-select').val();
            let fullPayment = parseFloat(card.find('.fullPayment').text().split('$')[1]) || 0;
            let downPayment = parseFloat(card.find('.downPayment').text().split('$')[1]) || 0;
            let monthlyPayment = parseFloat(card.find('.monthlyPayment').text().split('$')[1]) || 0;
            var brokerFee = card.find('#brokerFee').val();
            // var productId = {{ $quoteProduct->id }};
            var id = card.find('#quoteComparisonId').val();
            // var reccomended = card.find('#reccommendedCheckBox').is(':checked');

            var formData = {
                market: market,
                fullPayment: fullPayment,
                downPayment: downPayment,
                monthlyPayment: monthlyPayment,
                brokerFee: brokerFee,
                // productId: productId,
                // reccomended: reccomended,
                id: id
            };

            $.ajax({
                url: "{{ route('update-quotation-comparison') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: formData,
                success: function() {
                    Swal.fire({
                        title: 'Success',
                        text: 'has been saved',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            })
        });

        $(document).on('click', '.sendQuotationEmail', function() {
            var card = $(this).closest('.card');
            var id = card.find('#quoteComparisonId').val();
            var button = card.find('.ladda-button');
            var laddaButton = Ladda.create(button[0]);
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to send the quotation email?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading indicator
                    laddaButton.start();
                    $.ajax({
                        url: "{{ route('send-quotation') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function() {
                            // Close loading indicator
                            laddaButton.stop();

                            Swal.fire({
                                title: 'Success',
                                text: 'Email Has Been Sent',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function() {
                            // Close loading indicator
                            Swal.close();

                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
