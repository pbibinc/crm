<h6>Quoation <i class="ri-information-fill" style="vertical-align: middle; color: #6c757d;"></i></h6>
<div class="card">
    <div class="card-body">
        <div class="card border border-primary">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-10">

                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" id="addPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
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
                        <input id="fullPayment" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" inputmode="numeric" style="text-align: right;">
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

        <div id="cardContainer"></div>

    </div>

</div>
<script>
    $(document).ready(function (){
        $(document).on('click', '#addPriceComparisonButton', function(){

            let cardContent = `
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-9">

                        </div>
                        <div class="col-3 text-right">
                            <div class="row"></div>
                            <button class="btn btn-success addPriceComparison" id="addPriceComparisonButton"><i class="mdi mdi-plus-circle"></i></button>
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
                            <input id="fullPayment" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" inputmode="numeric" style="text-align: right;">
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
                    <button class="btn btn-primary saveFormButton">Save</button>
                </div>
                </div>
            </div>
        `;

        $('#cardContainer').append(cardContent);
        });

        $('#cardContainer').on('click', '.removeCardButton', function(){
            $(this).closest('.card').remove();
        });

        $(document).on('click', '.saveFormButton', function(){
            var $card = $(this).closest('.card');

            //form
            var market = $card.find('.form-select').val();
            var fullPayment = $card.find('#fullPayment').val();
            var downPayment = $card.find('#downPayment').val();
            var monthlyPayment = $card.find('#monthlyPayment').val();
            var brokerFee = $card.find('#brokerFee').val();
            var leadId = $('#leadId').val();

            var formData = {
                market: market,
                fullPayment: fullPayment,
                downPayment: downPayment,
                monthlyPayment: monthlyPayment,
                brokerFee: brokerFee,
                leadId: leadId
            };

            $.ajax({
                url: "{{ route('save-quotation-information') }}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: formData,
                success: function(){
                    Swal.fire({
                        title: 'Success',
                        text: 'has been saved',
                        icon: 'success'
                    });
                }
            })


        });
    });
</script>
