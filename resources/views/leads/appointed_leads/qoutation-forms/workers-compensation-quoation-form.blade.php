<div class="col-6 title-card">
    <h4 class="card-title mb-0" style="color: #ffffff">Workers Compensation Quoation Form</h4>
</div>

        <div class="card border border-primary workersCompFirsCardForm">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-10">
                        <input class="form-check-input" type="checkbox" id="workerscompReccommendedCheckBox">
                        <label class="form-check-label" for="formCheck1">Reccomend This Quote</label>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" id="addWorkCompPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div>
                        <select name="" id="" class="form-select">
                            <option value="">Select Market</option>
                            @foreach ($quationMarket as $market)
                            <option value={{ $market->id }}>{{ $market->name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="col-6">
                        <label for="filterBy" class="form-label mt-2" >Full Payment:</label>
                        <input id="fullPayment" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="filterBy" class="form-label mt-2">Down Payment:</label>
                        <input class="form-control" id="downPayment" type="text">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="col-6">
                        <label for="filterBy" class="form-label mt-2">Montly Payment:</label>
                        <input class="form-control mt-2"  id="monthlyPayment" type="text">
                    </div>
                    <div class="col-6">
                        <label for="filterBy" class="form-label">Broker Fee:</label>
                        <input class="form-control" id="brokerFee" type="text">
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <button class="btn btn-primary saveWorkersCompFormButton">Save</button>
                </div>
                <input class="form-control" value={{ $generalInformation->lead->id }} id="leadId" type="hidden">
            </div>
        </div>

        <div id="workerCompContainer"></div>

        <div class="col-12">
            <div class="d-grid mb-3">
                @if ($quoteProduct->status === 2)
                    <button type="button" class="btn btn-outline-success btn-lg waves-effect waves-light" id="saveWorkersCompQuoationProduct">Save Quotation</button>
                @else
                <button type="button" class="btn btn-outline-success btn-lg waves-effect waves-light" id="saveWorkersCompQuoationProduct" disabled>Save Quotation</button>
                @endif
            </div>
        </div>
<script>
    $(document).ready(function (){
        $('#saveWorkersCompQuoationProduct').on('click', function(){
            var id = {{ $quoteProduct->id }};
            $.ajax({
                url: "{{ route('send-quotation-product') }}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: {id: id},
                success: function(){
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
                error: function(jqXHR, textStatus, errorThrown){
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                    console.log(errorThrown);
                }
            });
        });
        let quoteComparison;
        $.ajax({
            url: "{{ route('get-comparison-data') }}",
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "GET",
            data: {id: {{$quoteProduct->id}}},
            success: function(data){
                quoteComparison = data.quoteComparison;
                market = data.market;
                doSomethingWithQuoteComparison();
            },
            error: function(){

            }
        });

      function  doSomethingWithQuoteComparison() {
        if(quoteComparison.length > 0){
            $('.workersCompFirsCardForm').hide();
           quoteComparison.forEach(function(data) {
           let selectOptions = `<option value="">Select Market</option>`;
           market.forEach(function(market) {
              selectOptions += `<option value="${market.id}" ${market.id === data.quotation_market_id ? 'selected' : ''}>${market.name}</option>`;
           });
           let cardContent = `
           <div class="col-6">
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="reccommendedCheckBox" ${data.recommended === 1 ? 'checked' : '' }>
                            <label class="form-check-label" for="formCheck1">Reccomend This Quote</label>
                        </div>
                        <div>
                            <button class="btn btn-success rounded-circle addWorkersCompPriceComparison" id="addPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
                            <button class="btn btn-danger rounded-circle removeSavedDataButton"><i class="mdi mdi-minus-circle"></i></button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div>
                            <label for="filterBy" class="form-label" >Select Market:</label>
                            <select name="" id="" class="form-select">
                               ${selectOptions}
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label" >Full Payment:</label>
                            <input id="fullPayment"  class="form-control  type="text" value="${data.full_payment}">
                        </div>
                        <div class="col-6">
                            <label for="filterBy" class="form-label">Down Payment:</label>
                            <input class="form-control" id="downPayment" type="text" value="${data.down_payment}">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label">Montly Payment:</label>
                            <input class="form-control" id="monthlyPayment" type="text" value="${data.monthly_payment}">
                        </div>
                        <div class="col-6">
                            <label for="filterBy" class="form-label">Broker Fee:</label>
                            <input class="form-control" id="brokerFee" type="text" value="${data.broker_fee}">
                        </div>
                    </div>
                    <input type="hidden" value="${data.id}" id="quoteComparisonId"/>
                    <hr>
                <div class="text-center">
                    <button class="btn btn-lg btn-success editWorkersCompFormButton">Save</button>
                </div>
                </div>
            </div>
            </div>
           `;
           let lastRow = $('#workerCompContainer > .row:last-child');
            if (lastRow.length == 0 || lastRow.children().length == 2) {
                // Either no rows or the last row already has 2 cards, so create a new row
             $('#workerCompContainer').append('<div class="row">' + cardContent + '</div>');
            }else {
               // Last row exists and only has 1 card, so append the new card there
              lastRow.append(cardContent);
            }
        //    $('#workerCompContainer').append(cardContent);
          });

        }
        };


        $(document).on('click', '.addWorkersCompPriceComparison', function(){

         let cardContent = `
         <div class="col-6">
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="col-8">
                            <input class="form-check-input" type="checkbox" id="workerscompReccommendedCheckBox">
                            <label class="form-check-label" for="formCheck1">Reccomend This Quote</label>
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-success rounded-circle addWorkersCompPriceComparison" id="addPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
                            <button class="btn btn-danger rounded-circle removeCardButton"><i class="mdi mdi-minus-circle"></i></button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div>
                            <label for="filterBy" class="form-label" >Select Market:</label>
                            <select name="" id="" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                   <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label" >Full Payment:</label>
                            <input id="fullPayment" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="filterBy" class="form-label">Down Payment:</label>
                            <input class="form-control" id="downPayment" type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-6">
                            <label for="filterBy" class="form-label">Montly Payment:</label>
                            <input class="form-control" id="monthlyPayment" type="text">
                        </div>
                        <div class="col-6">
                            <label for="filterBy" class="form-label">Broker Fee:</label>
                            <input class="form-control" id="brokerFee" type="text">
                        </div>
                    </div>
                    <hr>
                <div class="text-center">
                    <button class="btn btn-lg btn-success saveWorkersCompFormButton">Save</button>
                </div>
                </div>
            </div>
          </div>
        `;
        let lastRow = $('#workerCompContainer > .row:last-child');
            if (lastRow.length == 0 || lastRow.children().length == 2) {
                // Either no rows or the last row already has 2 cards, so create a new row
             $('#workerCompContainer').append('<div class="row">' + cardContent + '</div>');
            }else {
               // Last row exists and only has 1 card, so append the new card there
              lastRow.append(cardContent);
            }
        // $('#workerCompContainer').append(cardContent);
        });

        $('#workerCompContainer').on('click', '.removeCardButton', function(){
            $(this).closest('.card').remove();

        });
        $(".input-mask").inputmask();

        $('#workerCompContainer').on('click', '.removeSavedDataButton', function(){
            var $card = $(this).closest('.card');

            Swal.fire({
                 title: 'Are you sure?',
                 text: 'You will not be able to recover this!',
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonText: 'Yes, delete it!',
                 cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $card.find('#quoteComparisonId').val();
                    $.ajax({
                        url: "{{ route('delete-quotation-comparison') }}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method: "POST",
                        data: {id: id},
                        success: function(){
                            Swal.fire({
                                title: 'Success',
                                text: 'has been deleted',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                    $card.remove();
                                }
                            });
                        },
                        error: function(){
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }
                    })
                }
            });

            var id = $card.find('#quoteComparisonId').val();
        });

        $(document).on('click', '.saveWorkersCompFormButton', function(){
            var $card = $(this).closest('.card');

            //form
            var market = $card.find('.form-select').val();
            var fullPayment = $card.find('#fullPayment').val();
            var downPayment = $card.find('#downPayment').val();
            var monthlyPayment = $card.find('#monthlyPayment').val();
            var brokerFee = $card.find('#brokerFee').val();
            var reccomended = $card.find('#workerscompReccommendedCheckBox').is(':checked');
            var id = {{$quoteProduct->id}};


            var formData = {
                market: market,
                fullPayment: fullPayment,
                downPayment: downPayment,
                monthlyPayment: monthlyPayment,
                brokerFee: brokerFee,
                reccomended: reccomended,
                id: id
            };

            $.ajax({
                url: "{{ route('save-quotation-comparison') }}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: formData,
                success: function(){
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
                error: function(){
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            })
        });

        $(document).on('click', '.editWorkersCompFormButton', function(){
            var $card = $(this).closest('.card');

            //form
            var market = $card.find('.form-select').val();
            var fullPayment = $card.find('#fullPayment').val();
            var downPayment = $card.find('#downPayment').val();
            var monthlyPayment = $card.find('#monthlyPayment').val();
            var brokerFee = $card.find('#brokerFee').val();
            var productId = {{$quoteProduct->id}};
            var id = $card.find('#quoteComparisonId').val();
            var reccomended = $card.find('#reccommendedCheckBox').is(':checked');

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
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: formData,
                success: function(){
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
                error: function(){
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            })

        });


    });
</script>
