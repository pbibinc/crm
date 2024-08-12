@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Sales</p>
                                            <h4 class="mb-2">{{ $totalSales }}</h4>
                                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2">

                                                    <i
                                                        class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $salesPercentage }}%</span>from
                                                previous month</p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                <i class="ri-shopping-cart-2-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Appointed Product</p>
                                            <h4 class="mb-2">{{ $totalAppointedProduct }}</h4>
                                            <p class="text-muted mb-0"><span
                                                    class="text-success fw-bold font-size-12 me-2"><i
                                                        class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $appointedProductPercentage }}%</span>from
                                                previous month</p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="ri-user-3-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end d-none d-md-inline-block">
                                <div class="dropdown card-header-dropdown">
                                    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                        <a class="dropdown-item" href="#">Export</a>
                                        <a class="dropdown-item" href="#">Import</a>
                                        <a class="dropdown-item" href="#">Download Report</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Sales Report</h4>
                            <div class="text-center pt-3">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">25,117</h5>
                                            <div class="text-success font-size-12">
                                                <i class="mdi mdi-menu-up font-size-14"> </i>2.2 %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">Marketplace</p>
                                    </div><!-- end col -->
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">$34,856</h5>
                                            <div class="text-success font-size-12">
                                                <i class="mdi mdi-menu-up font-size-14"> </i>1.2 %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">Last Week</p>
                                    </div><!-- end col -->
                                    <div class="col-sm-4">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">$18,225</h5>
                                            <div class="text-success font-size-12">
                                                <i class="mdi mdi-menu-up font-size-14"> </i>1.7 %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">Last Month</p>
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div>
                            <div class="row">
                                <div id="salesReport" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end d-none d-md-inline-block">
                                <div class="dropdown card-header-dropdown">
                                    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                        <a class="dropdown-item" href="#">Export</a>
                                        <a class="dropdown-item" href="#">Import</a>
                                        <a class="dropdown-item" href="#">Download Report</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Sales Type</h4>
                            <div class="text-center pt-3">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">25,117</h5>
                                            <div class="text-success font-size-12">
                                                <i class="mdi mdi-menu-up font-size-14"> </i>2.2 %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">Marketplace</p>
                                    </div><!-- end col -->
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">$34,856</h5>
                                            <div class="text-success font-size-12">
                                                <i class="mdi mdi-menu-up font-size-14"> </i>1.2 %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">Last Week</p>
                                    </div><!-- end col -->
                                    <div class="col-sm-4">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">$18,225</h5>
                                            <div class="text-success font-size-12">
                                                <i class="mdi mdi-menu-up font-size-14"> </i>1.7 %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">Last Month</p>
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div>
                            <div class="row">
                                <div id="salesType" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            var options = {
                chart: {
                    type: 'bar'
                },
                series: [{
                        name: 'Last Year',
                        data: [20, 30, 35, 45, 10, 20, 60]
                    },
                    {
                        name: 'This Year',
                        data: [30, 40, 35, 50, 49, 60, 70]
                    }
                ],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July']
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%', // Adjust this to add space between bars
                        endingShape: 'rounded',
                        borderRadius: 5, // Make bars more rounded
                    }
                },
                dataLabels: {
                    enabled: false
                },
            }
            var salesOption = {
                chart: {
                    type: 'donut',
                    height: '543'
                },
                // series: {!! json_encode($totalSalesPerType) !!},
                series: [25, 15, 44, 55, 41],
                labels: ['Direct New', 'Direct Renewals', 'Recover', 'Audit', 'Endorsements'],
                plotOptions: {
                    pie: {
                        size: '20%',
                    }
                },
            }
            var chart = new ApexCharts(document.querySelector("#salesReport"), options);
            var salesChart = new ApexCharts(document.querySelector("#salesType"), salesOption);
            chart.render();
            salesChart.render();

        });
    </script>
@endsection
