<div class="modal fade bs-example-modal-xl" tabindex="-1" id="leadsDataModal" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Extra large modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Apptaker Questionare</h4>

                            <div id="progrss-wizard" class="twitter-bs-wizard">

                                <ul class="twitter-bs-wizard-nav nav-justified">

                                    <li class="nav-item">
                                        <a href="#progress-seller-details" class="nav-link" data-toggle="tab"
                                            id="progressSellerDetails">
                                            <span class="step-number">01</span>
                                            <span class="step-title">General Information</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#progress-company-document" class="nav-link" data-toggle="tab"
                                            id="progressCompanyDocument">
                                            <span class="step-number">02</span>
                                            <span class="step-title">Products</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#progress-bank-detail" class="nav-link" data-toggle="tab"
                                            id="progressBankDetail">
                                            <span class="step-number">03</span>
                                            <span class="step-title">Confirm Details</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab"
                                            id="progressConfirmDetail">
                                            <span class="step-number">04</span>
                                            <span class="step-title">Submission</span>
                                        </a>
                                    </li>

                                </ul>

                                <div id="bar" class="progress mt-4">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated">
                                    </div>
                                </div>

                                <!-- Include file for step 1 general information form-->
                                @include('leads.apptaker_leads.general-information')

                                <div class="tab-pane" id="progress-company-document">
                                    <div class="row">

                                        <!-- Product Nav tabs -->
                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab"
                                                    href="#general-liability-1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">General Liability</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#worker-comp-1"
                                                    role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Workers Comp</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#commercial-auto-1"
                                                    role="tab">
                                                    <span class="d-block d-sm-none"><i
                                                            class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">Commercial Auto</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#excess-liability-1"
                                                    role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">Excess Liability</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#tools-equipment-1"
                                                    role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">Tools Equipment</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#builders-risk-1"
                                                    role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">Builder Risk</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#business-owner-1"
                                                    role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">BOP</span>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">

                                            @include('leads.apptaker_leads.general-liabilities')

                                            @include('leads.apptaker_leads.workers-comp')

                                            @include('leads.apptaker_leads.commercial-auto')

                                            @include('leads.apptaker_leads.excess-liability')

                                            @include('leads.apptaker_leads.tools-equipment')

                                            @include('leads.apptaker_leads.builders-risk')

                                            @include('leads.apptaker_leads.business-owners')

                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-bank-detail">
                                    @include('leads.apptaker_leads.confirm-details')
                                </div>


                                {{-- submission part --}}
                                <div class="tab-pane" id="progress-confirm-detail">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="text-center">
                                                <div class="mb-4">
                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                </div>
                                                <div>
                                                    <h5>Confirm Detail</h5>
                                                    <p class="text-muted">If several languages coalesce, the grammar of
                                                        the resulting</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End of Submission --}}

                            </div>


                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                <li class="next" id="nextButtonContainer"><a href="javascript: void(0);"
                                        id="nextButton">Next</a></li>
                                <li class="submit" style="display: none;" id="submitButtonContainer"><button
                                        type="submit" id="submitButton" class="btn btn-primary">Submit</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    //    $('#progress-bank-detail').on('click', function(){
    //         console.log('this test the progress-bank-detail');
    //         var activeStep = $('.nav-link.active').attr('href');
    //         if(activeStep == '#progress-bank-detail'){
    //             $('#nextButtonContainer').hide();
    //             $('#submitButtonContainer').show();
    //         }
    //         if(activeStep == '#progress-company-document'){
    //             $('#nextButtonContainer').show();
    //             $('#submitButtonContainer').hide();
    //         }
    //         if(activeStep == '#progress-company-document'){
    //             $('#nextButtonContainer').show();
    //             $('#submitButtonContainer').hide();
    //         }
    //     });
    //     $('#progress-bank-detail').on('click', function(){
    //         console.log('this test the progress-bank-detail');
    //         var activeStep = $('.nav-link.active').attr('href');
    //         if(activeStep == '#progress-bank-detail'){
    //             $('#nextButtonContainer').hide();
    //             $('#submitButtonContainer').show();
    //         }
    //         if(activeStep == '#progress-company-document'){
    //             $('#nextButtonContainer').show();
    //             $('#submitButtonContainer').hide();
    //         }
    //         if(activeStep == '#progress-company-document'){
    //             $('#nextButtonContainer').show();
    //             $('#submitButtonContainer').hide();
    //         }
    //     });

    //     $('#progress-bank-detail').on('click', function(){
    //         console.log('this test the progress-bank-detail');
    //         var activeStep = $('.nav-link.active').attr('href');
    //         if(activeStep == '#progress-bank-detail'){
    //             $('#nextButtonContainer').hide();
    //             $('#submitButtonContainer').show();
    //         }
    //         if(activeStep == '#progress-company-document'){
    //             $('#nextButtonContainer').show();
    //             $('#submitButtonContainer').hide();
    //         }
    //         if(activeStep == '#progress-company-document'){
    //             $('#nextButtonContainer').show();
    //             $('#submitButtonContainer').hide();
    //         }
    //     });
</script>
