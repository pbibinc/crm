<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        @php
            $user = Auth::user();
            $id = $user->id;
            $adminData = App\Models\User::find($id);
            $userProfile = $user->userProfile;
        @endphp

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{asset($userProfile->media->filepath)}}" alt="" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{$userProfile->firstname . ' ' . $userProfile->american_surname}}</h4>
                <p class="mb-0"><em>{{$userProfile->position->name}}</em></p>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                @can('view', App\Models\Attendance::find(1))
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endcan

                <li class="menu-title">Admin</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-lock-line"></i>
                        <span>Security</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.users.index') }}">Accounts</a></li>
                        <li><a href="{{ route('admin.roles.index') }}" >Role</a></li>
                        @can('view', App\Models\Permission::find(1))
                            <li><a href="{{ route('admin.permissions.index') }}" >Permission</a></li>
                        @endcan
                    </ul>
                </li>
                <li>
                    @can('viewAny', App\Models\UserProfile::find(1))
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-user-2-line" ></i>
                        <span>Administrator</span>
                    </a>
                    @endcan
                    <ul class="sub-menu" aria-expanded="false">
                        @can('view', App\Models\Position::find(1))
                            <li><a href="{{ route('admin.positions.index') }}" >Position</a></li>
                        @endcan

                        @can('view', App\Models\Department::find(1))
                        <li><a href="{{ route('admin.departments.index') }}" >Departments</a></li>
                            @endcan
                            @can('view', App\Models\UserProfile::find(1))
                                <li><a href="{{ route('admin.user-profiles.index') }}" >User Profile</a></li>
                            @endcan

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" >
                        <i class="mdi mdi-account-group-outline" style="font-size: 22px" ></i>
                        <span>Departments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('it-department') }}" >IT DEPARTMENT</a></li>
                     <li><a href="{{ route('csr-department') }}" >CSR DEPARTMENT</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" >
                        <i class="ri-profile-line"></i>
                        <span>QOUTATION FORMS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html" >Application Forms</a></li>
                        <li><a href="pages-starter.html" >General Information</a></li> --}}

{{--                        <li><a href="pages-timeline.html">Timeline</a></li>--}}
{{--                        <li><a href="pages-directory.html">Directory</a></li>--}}
{{--                        <li><a href="pages-invoice.html">Invoice</a></li>--}}
{{--                        <li><a href="pages-404.html">Error 404</a></li>--}}
{{--                        <li><a href="pages-500.html">Error 500</a></li>--}}
                    {{-- </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>HR</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class=""><a href="javascript: void(0);" class="has-arrow" aria-expanded="true">Leave Forms</a>
                            <ul class="sub-menu mm-collapse mm-show" aria-expanded="true" style="">
                                <li><a href="javascript: void(0);">Vacation Leave</a></li>
                                <li><a href="javascript: void(0);">Sick Leave</a></li>
                                <li><a href="javascript: void(0);">Emergency Leave</a></li>
                                <li><a href="javascript: void(0);">Birthday Leave</a></li>
                            </ul>
                        </li>
                        {{-- <li><a href="{{ route('hrforms.') }}">Memos</a></li> --}}
                        <li><a href="{{ route('hrforms.attendance-records-index') }}">Attendance Records</a></li>
                        <li><a href="javascript: void(0);">Online Monitoring</a></li>
                        <li><a href="{{ route('hrforms.birthday-calendar-index') }}">Birthday Calendar</a></li>
                        <li><a href="{{ route('hrforms.company-handbook') }}">Company Handbook</a></li>
                        <li class=""><a href="javascript: void(0);" class="has-arrow" aria-expanded="true">Other Forms</a>
                            <ul class="sub-menu mm-collapse mm-show" aria-expanded="true" style="">
                                <li><a href="{{ route('hrforms.accountability-form') }}">Accountability Form</a></li>
                                <li><a href="{{ route('hrforms.incident-report-form') }}">Incident Report</a></li>
                                <li><a href="javascript: void(0);">Proposal Form</a></li>
                                <li><a href="javascript: void(0);">Disposal Form</a></li>
                                <li><a href="javascript: void(0);">MoM (Minutes of Meeting) Form</a></li>
                            </ul>
                        </li>
                    </ul>


               <li class="menu-title">Sales</li>
               <li>
                @can('view', App\Models\Lead::find(1))
                    <a href="javascript: void(0);" class="has-arrow waves-effect" >
                        <i class="ri-headphone-fill"></i>
                        <span>App Taker</span>
                    </a>
                @endcan

                <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('apptaker-leads')}}">Lead List</a></li>
                        <li><a href="{{route('apptaker-leads')}}">Call Back</a></li>
                        <li><a href="{{route('apptaker-leads')}}">Lead List</a></li>
                </ul>
            </li>

               <li>
                   <a href="javascript: void(0);" class="has-arrow waves-effect">
                       <i class="ri-clipboard-fill"></i>
                       <span>Quotation</span>
                   </a>
                   <ul class="sub-menu" aria-expanded="false">
                       <li><a href="{{route('appointed-leads')}}">For Qoute Leads</a></li>
                       <li><a href="{{route('assign-appointed-lead')}}">Assign Appointed Leads</a></li>
{{--                        <li><a href="ui-buttons.html">Buttons</a></li>--}}
{{--                        <li><a href="ui-cards.html">Cards</a></li>--}}
{{--                        <li><a href="ui-carousel.html">Carousel</a></li>--}}
{{--                        <li><a href="ui-dropdowns.html">Dropdowns</a></li>--}}
{{--                        <li><a href="ui-grid.html">Grid</a></li>--}}
{{--                        <li><a href="ui-images.html">Images</a></li>--}}
{{--                        <li><a href="ui-lightbox.html">Lightbox</a></li>--}}
{{--                        <li><a href="ui-modals.html">Modals</a></li>--}}
{{--                        <li><a href="ui-offcanvas.html">Offcavas</a></li>--}}
{{--                        <li><a href="ui-progressbars.html">Progress Bars</a></li>--}}
{{--                        <li><a href="ui-tabs-accordions.html">Tabs & Accordions</a></li>--}}
{{--                        <li><a href="ui-typography.html">Typography</a></li>--}}
{{--                        <li><a href="ui-video.html">Video</a></li>--}}
{{--                        <li><a href="ui-general.html">General</a></li>--}}

                   </ul>
               </li>

               <li class="menu-title">Leads</li>
               <li>
                @can('view', App\Models\Lead::find(1))
                    <a href="javascript: void(0);" class="has-arrow waves-effect" >
                        <i class="ri-spy-fill"></i>
                        <span>LEADS FUNNEL</span>
                    </a>
                @endcan

            <ul class="sub-menu" aria-expanded="false">
                @can('viewImport', App\Models\Lead::find(1))
                    <li><a href="{{route('leads')}}" >Import Leads</a></li>
                @endcan
                @can('viewLeadsFunnel', App\Models\Lead::find(1))
                <li><a href="{{route('assign')}}" >Assign Leads</a></li>
                    @endcan
                <li><a href="pages-directory.html">Leads Profile</a></li>
                {{--                        <li><a href="pages-invoice.html">Invoice</a></li>--}}
                {{--                        <li><a href="pages-404.html">Error 404</a></li>--}}
                {{--                        <li><a href="pages-500.html">Error 500</a></li>--}}
            </ul>

        </li>

               {{-- <li>
                   <a href="javascript: void(0);" class="has-arrow waves-effect">
                       <i class="ri-vip-crown-2-line"></i>
                       <span>Leads</span>
                   </a>
                   <ul class="sub-menu" aria-expanded="false"> --}}

{{--                        <li><a href="advance-rangeslider.html">Range Slider</a></li>--}}
{{--                        <li><a href="advance-roundslider.html">Round Slider</a></li>--}}
{{--                        <li><a href="advance-session-timeout.html">Session Timeout</a></li>--}}
{{--                        <li><a href="advance-sweet-alert.html">Sweetalert 2</a></li>--}}
{{--                        <li><a href="advance-rating.html">Rating</a></li>--}}
{{--                        <li><a href="advance-notifications.html">Notifications</a></li>--}}
                   {{-- </ul>
               </li> --}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="waves-effect">--}}
{{--                        <i class="ri-eraser-fill"></i>--}}
{{--                        <span class="badge rounded-pill bg-danger float-end">8</span>--}}
{{--                        <span>Forms</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li><a href="form-elements.html">Form Elements</a></li>--}}
{{--                        <li><a href="form-validation.html">Form Validation</a></li>--}}
{{--                        <li><a href="form-advanced.html">Form Advanced Plugins</a></li>--}}
{{--                        <li><a href="form-editors.html">Form Editors</a></li>--}}
{{--                        <li><a href="form-uploads.html">Form File Upload</a></li>--}}
{{--                        <li><a href="form-xeditable.html">Form X-editable</a></li>--}}
{{--                        <li><a href="form-wizard.html">Form Wizard</a></li>--}}
{{--                        <li><a href="form-mask.html">Form Mask</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="has-arrow waves-effect">--}}
{{--                        <i class="ri-table-2"></i>--}}
{{--                        <span>Tables</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li><a href="tables-basic.html">Basic Tables</a></li>--}}
{{--                        <li><a href="tables-datatable.html">Data Tables</a></li>--}}
{{--                        <li><a href="tables-responsive.html">Responsive Table</a></li>--}}
{{--                        <li><a href="tables-editable.html">Editable Table</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="has-arrow waves-effect">--}}
{{--                        <i class="ri-bar-chart-line"></i>--}}
{{--                        <span>Charts</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li><a href="charts-apex.html">Apex Charts</a></li>--}}
{{--                        <li><a href="charts-chartjs.html">Chartjs Charts</a></li>--}}
{{--                        <li><a href="charts-flot.html">Flot Charts</a></li>--}}
{{--                        <li><a href="charts-knob.html">Jquery Knob Charts</a></li>--}}
{{--                        <li><a href="charts-sparkline.html">Sparkline Charts</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="has-arrow waves-effect">--}}
{{--                        <i class="ri-brush-line"></i>--}}
{{--                        <span>Icons</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li><a href="icons-remix.html">Remix Icons</a></li>--}}
{{--                        <li><a href="icons-materialdesign.html">Material Design</a></li>--}}
{{--                        <li><a href="icons-dripicons.html">Dripicons</a></li>--}}
{{--                        <li><a href="icons-fontawesome.html">Font awesome 5</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="has-arrow waves-effect">--}}
{{--                        <i class="ri-map-pin-line"></i>--}}
{{--                        <span>Maps</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li><a href="maps-google.html">Google Maps</a></li>--}}
{{--                        <li><a href="maps-vector.html">Vector Maps</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="has-arrow waves-effect">--}}
{{--                        <i class="ri-share-line"></i>--}}
{{--                        <span>Multi Level</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="true">--}}
{{--                        <li><a href="javascript: void(0);">Level 1.1</a></li>--}}
{{--                        <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>--}}
{{--                            <ul class="sub-menu" aria-expanded="true">--}}
{{--                                <li><a href="javascript: void(0);">Level 2.1</a></li>--}}
{{--                                <li><a href="javascript: void(0);">Level 2.2</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
