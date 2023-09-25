<h6>Workers Compensation Quoation Form<i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
<div class="card ">
    <div class="card-body">
        <div class="card border border-primary workersCompFirsCardForm">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-10">

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
                <div class="row mb-4">
                    <div class="col-4">
                        <label for="filterBy" class="form-label mt-2" >Full Payment:</label>
                    </div>
                    <div class="col-8">
                        <input id="fullPayment" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-4">
                        <label for="filterBy" class="form-label mt-2">Down Payment:</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control" id="downPayment" type="text">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-4">
                        <label for="filterBy" class="form-label mt-2">Montly Payment:</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control mt-2"  id="monthlyPayment" type="text">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-4">
                        <label for="filterBy" class="form-label">Broker Fee:</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control" id="brokerFee" type="text">
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-primary saveFormButton">Save</button>
                </div>
                <input class="form-control" value={{ $generalInformation->lead->id }} id="leadId" type="hidden">
            </div>
        </div>

        <div id="workerCompContainer"></div>

    </div>

</div>
<script>
    $(document).ready(function (){
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
                console.log('error');
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
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-8">

                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-success addWorkersCompPriceComparison" id="addPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
                            <button class="btn btn-danger removeSavedDataButton"><i class="mdi mdi-minus-circle"></i></button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div>
                            <select name="" id="" class="form-select">
                               ${selectOptions}
                            </select>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label mt-2" >Full Payment:</label>
                        </div>
                        <div class="col-8">
                            <input id="fullPayment"  class="form-control  type="text" value="${data.full_payment}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label mt-2">Down Payment:</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control" id="downPayment" type="text" value="${data.down_payment}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label mt-2">Montly Payment:</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control mt-2" id="monthlyPayment" type="text" value="${data.monthly_payment}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label">Broker Fee:</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control" id="brokerFee" type="text" value="${data.broker_fee}">
                        </div>
                    </div>
                    <input type="hidden" value="${data.id}" id="quoteComparisonId"/>
                <div class="row">
                    <button class="btn btn-lg btn-success editFormButton">Save</button>
                </div>
                </div>
            </div>
           `;
           $('#workerCompContainer').append(cardContent);
          });

        }
        };


        $(document).on('click', '.addWorkersCompPriceComparison', function(){

         let cardContent = `
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-8">

                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-success addWorkersCompPriceComparison" id="addPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
                            <button class="btn btn-danger removeCardButton"><i class="mdi mdi-minus-circle"></i></button>
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
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label mt-2" >Full Payment:</label>
                        </div>
                        <div class="col-8">
                            <input id="fullPayment" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label mt-2">Down Payment:</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control" id="downPayment" type="text">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label mt-2">Montly Payment:</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control mt-2" id="monthlyPayment" type="text">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for="filterBy" class="form-label">Broker Fee:</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control" id="brokerFee" type="text">
                        </div>
                    </div>
                <div class="row">
                    <button class="btn btn-lg btn-success saveFormButton">Save</button>
                </div>
                </div>
            </div>
        `;

        $('#workerCompContainer').append(cardContent);
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

        $(document).on('click', '.saveFormButton', function(){
            var $card = $(this).closest('.card');

            //form
            var market = $card.find('.form-select').val();
            var fullPayment = $card.find('#fullPayment').val();
            var downPayment = $card.find('#downPayment').val();
            var monthlyPayment = $card.find('#monthlyPayment').val();
            var brokerFee = $card.find('#brokerFee').val();
            var id = {{$quoteProduct->id}};


            var formData = {
                market: market,
                fullPayment: fullPayment,
                downPayment: downPayment,
                monthlyPayment: monthlyPayment,
                brokerFee: brokerFee,
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

        $(document).on('click', '.editFormButton', function(){
            var $card = $(this).closest('.card');

            //form
            var market = $card.find('.form-select').val();
            var fullPayment = $card.find('#fullPayment').val();
            var downPayment = $card.find('#downPayment').val();
            var monthlyPayment = $card.find('#monthlyPayment').val();
            var brokerFee = $card.find('#brokerFee').val();
            var productId = {{$quoteProduct->id}};
            var id = $card.find('#quoteComparisonId').val();

            var formData = {
                market: market,
                fullPayment: fullPayment,
                downPayment: downPayment,
                monthlyPayment: monthlyPayment,
                brokerFee: brokerFee,
                productId: productId,
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
