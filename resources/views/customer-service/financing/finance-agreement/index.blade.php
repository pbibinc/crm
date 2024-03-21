@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#request-for-pfa" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Request For PFA</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#creation-of-pfa" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Creation of PFA</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#bound" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Incomplete PFA</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#new-pfa" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">New PFA</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="request-for-pfa" role="tabpanel">
                        @include('customer-service.financing.finance-agreement.request-for-financing')
                    </div>
                    <div class="tab-pane" id="creation-of-pfa" role="tabpanel">
                        @include(
                            'customer-service.financing.finance-agreement.create-pfa',
                            compact('financeCompany'))
                    </div>
                    <div class="tab-pane" id="creation-of-pfa" role="tabpanel">

                    </div>
                    <div class="tab-pane" id="new-pfa" role="tabpanel">
                        @include('customer-service.financing.finance-agreement.new-pfa')
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script></script>
@endsection
