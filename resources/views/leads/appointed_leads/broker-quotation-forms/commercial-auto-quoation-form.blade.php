<style>
    /* Additional styling for buttons and other elements */
    .btn-enhanced {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-right: 10px;
    }

    .btn-enhanced:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }

    .btn-enhanced:last-child {
        margin-right: 0;
    }

    .title-container {
        display: flex;
        align-items: center;
    }

    .star-icon {
        margin-left: 8px;
        margin-bottom: 6px;
    }

    .fee-container {
        display: flex;
        align-items: center;
    }

    .fee-input {
        margin-left: 10px;
    }

    .text-center {
        margin-top: 20px;
    }
</style>
<h6>Commercial Auto Quoation Form<i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>

<div id="CommercialAutoContainer" class="mt-2"></div>

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
                doSomethingWithQuoteComparisonCommercialAuto();
            },
            error: function() {

            }
        });

        function doSomethingWithQuoteComparisonCommercialAuto() {
            if (quoteComparison.length > 0) {
                $('.commercialAutoFirsCardForm').hide();
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
                            <label for="filterBy" class="form-label mt-2" >Full Payment: $${data.full_payment}</label>
                        </div>
                        <div class="col-6">
                            <label for="filterBy" class="form-label mt-2">Down Payment: $${data.down_payment}</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label mt-2">Montly Payment: $${data.monthly_payment}</label>
                        </div>
                        <div class="col-6">
                            <div style="display: flex; align-items: center;">
                               <label for="filterBy" class="form-label mt-2">Fee:</label>
                               <input class="form-control" id="brokerFee" style="margin-left: 10px;" type="text" value="${data.broker_fee}">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" value="${data.id}" id="quoteComparisonId"/>

                    <div class="row d-flex text-center">
                      <div class="col-12">
                        <div class="button-container">
                        <!-- Send Quotation Email Button -->
                                 <button type="button" class="btn btn-lg btn-primary waves-effect waves-light sendEmail ladda-button" data-style="expand-right" data-toggle="tooltip" title="Send Quotation Email">
                                 <i class="ri-mail-send-line"></i> Send
                                 </button>

                                 <!-- Save Button -->
                                 <button type="button" class="btn btn-lg btn-success editCommercialAutoButton" data-toggle="tooltip" title="Save Form">
                                 <i class="ri-save-line"></i> Save
                                 </button>
                        </div>
                     </div>
                    </div>
                </div>
            </div>
           `;
                    let lastRow = $('#CommercialAutoContainer > .row:last-child');
                    if (lastRow.length == 0 || lastRow.children().length == 2) {
                        // Either no rows or the last row already has 2 cards, so create a new row
                        $('#CommercialAutoContainer').append('<div class="row">' + cardContent +
                            '</div>');
                    } else {
                        // Last row exists and only has 1 card, so append the new card there
                        lastRow.append(cardContent);
                    }
                    //    $('#CommercialAutoContainer').append(cardContent);
                });
            }
        };

        $(document).on('click', '.editCommercialAutoButton', function() {
            var card = $(this).closest('.card');

            //form
            var market = card.find('.form-select').val();
            var fullPayment = card.find('#fullPayment').val();
            var downPayment = card.find('#downPayment').val();
            var monthlyPayment = card.find('#monthlyPayment').val();
            var brokerFee = card.find('#brokerFee').val();
            var productId = {{ $quoteProduct->id }};
            var id = card.find('#quoteComparisonId').val();
            var reccomended = card.find('#reccommendedCheckBox').is(':checked');

            var formData = {
                market: market,
                fullPayment: fullPayment,
                downPayment: downPayment,
                monthlyPayment: monthlyPayment,
                brokerFee: brokerFee,
                productId: productId,
                reccomended: reccomended,
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

        // $(document).on('click', '.sendEmail', function(){
        //  var card = $(this).closest('.card');
        //   //form
        //   var id = card.find('#quoteComparisonId').val();
        //   Swal.fire({
        //     title: 'Are you sure?',
        //     text: "You are about to send the quotation.",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, send it!'
        //   }).then((result) => {
        //     if(result.isConfirmed){
        //            // Show the loading spinner
        //            Swal.showLoading();
        //         $.ajax({
        //         url: "{{ route('send-quotation') }}",
        //         headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         method: "POST",
        //         data:{
        //             id: id,
        //         },
        //         success: function(){
        //             Swal.fire({
        //                 title: 'Success',
        //                 text: 'Email Has been sent',
        //                 icon: 'success',
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     location.reload();
        //                 }
        //             });
        //         },
        //         error: function(){
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Something went wrong',
        //                 icon: 'error'
        //             });
        //         }
        //     })
        //     }
        //   });


        // });

        $(document).on('click', '.sendEmail', function() {
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
                    laddaButton.start();
                    $.ajax({
                        url: "{{ route('send-quotation') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                .attr('content')
                        },
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function() {
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
