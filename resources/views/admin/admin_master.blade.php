@include('partials.main')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include("partials.title-meta")

    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div>

    <!-- Sweet Alert CSS-->
    <link href="{{asset('backend/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

    <!--Jquery extension -->
    <script src="{{asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <script src="{{asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- jquery.vectormap css -->
    {{-- <link href="{{asset('backend/assets/libs/admin-resources/jquery.vecto rmap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" /> --}}

    <!-- Add the evo-calendar.css for styling -->
    <link href="{{ asset('backend/assets/libs/evo-calendar/css/evo-calendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/evo-calendar/css/evo-calendar.royal-navy.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />

    <!-- Responsive Table css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@fullcalendar/core/main.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@fullcalendar/daygrid/main.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@fullcalendar/bootstrap/main.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@fullcalendar/timegrid/main.min.css') }}" type="text/css">



        @include("partials.head")

    <!-- JAVASCRIPT -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    {{-- <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script> --}}

    {{-- <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js')}}"></script>

    @include("partials.head")

    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/libs/evo-calendar/js/evo-calendar.js') }}"></script> --}}



{{--        <!-- Bootstrap Css -->--}}
{{--    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"--}}
{{--          type="text/css"/>--}}

{{--    <!-- Icons Css -->--}}
{{--    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>--}}

{{--    <!-- App Css-->--}}
{{--    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>--}}


{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}


</head>

@include("partials.body")

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">

@include("partials.menu")

{{--    @include('partials.header')--}}

{{--    <div class="main-content">--}}
{{--        <div class="page-content">--}}
{{--            <div class="container-fluid">--}}
{{--                @include('partials.page-title')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


    <!-- ========== Left Sidebar Start ========== -->
{{--    @include('partials.sidebar')--}}
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
{{--        <div id="notification" class="alert alert-success mx-3">test</div>--}}
        @yield('admin')
        <!-- End Page-content -->

        @include('partials.footer')


    </div>
    <!-- end main content--

<! END layout-wrapper -->
</div>
@include('partials.vendor-scripts')


<!-- Right Sidebar -->

<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>



<!-- apexcharts -->
{{-- <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.js') }}"></script>--}}



<!-- jquery.vectormap map -->
<script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


<!-- Buttons examples -->
<script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>

<script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

<!-- plugin js -->
{{-- <script src="{{ asset('backend/assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/@fullcalendar/core/main.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/@fullcalendar/bootstrap/main.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/@fullcalendar/daygrid/main.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/@fullcalendar/timegrid/main.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/@fullcalendar/interaction/main.min.js') }}"></script> --}}

<!-- Calendar init -->
{{-- <script src="{{ asset('backend/assets/js/pages/calendar.init.js') }}"></script> --}}

<!-- Responsive examples -->
<script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>
<script src="{{ asset('backend/assets/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/form-editor.init.js') }}"></script>

<!-- JAVASCRIPT -->
{{-- <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script> --}}
{{-- <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script> --}}
{{-- <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script> --}}

<!-- Responsive Table js -->
<script src="{{ asset('backend/assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>

<!-- Init js -->
<script src="{{ asset('backend/assets/js/pages/table-responsive.init.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>

<script src="{{ asset('backend/assets/libs/evo-calendar/js/evo-calendar.js') }}"></script>

<!-- App js -->
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{--form validation--}}
<link href="{{asset('backend/assets/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
<script src="{{asset('backend/assets/libs/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ asset('backend/assets/js/pages/form-advanced.init.js')}}"></script>
<script src="{{asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<!-- Sweet Alerts js -->
<script src="{{asset('backend/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Sweet alert init js-->
<script src="{{asset('backend/assets/js/pages/sweet-alerts.init.js')}}"></script>


<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>

</body>

</html>
