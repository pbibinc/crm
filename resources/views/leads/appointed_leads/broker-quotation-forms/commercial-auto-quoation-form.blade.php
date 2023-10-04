<h6>Commercial Auto Quoation Form<i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
<div class="card ">
    <div class="card-body">


        <div id="CommercialAutoContainer"></div>


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
                doSomethingWithQuoteComparisonCommercialAuto();
            },
            error: function(){

            }
        });

      function  doSomethingWithQuoteComparisonCommercialAuto() {
        if(quoteComparison.length > 0){
            $('.commercialAutoFirsCardForm').hide();
           quoteComparison.forEach(function(data) {
            const marketObj = market.find(market => market.id === data.quotation_market_id);
            const marketName = marketObj ? marketObj.name : 'Market Not Found';
            let cardContent = `
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div style="display: flex; align-items: center;">
                              <h4 class="card-title">Insurance Provider: ${marketName}</h4>
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
                    <div class="row mb-4">
                        <div class="col-4">

                        </div>
                        <div class="col-8">

                        </div>
                    </div>
                    <input type="hidden" value="${data.id}" id="quoteComparisonId"/>
                <div class="row">
                    <button class="btn btn-lg btn-success editCommercialAutoButton">Save</button>
                </div>
                </div>
            </div>
           `;
           $('#CommercialAutoContainer').append(cardContent);
          });

        }
        };



        $(document).on('click', '.editCommercialAutoButton', function(){
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
