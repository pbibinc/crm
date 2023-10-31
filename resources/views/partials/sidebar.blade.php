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
                <img src="{{ asset($userProfile->media->filepath) }}" alt="" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ $userProfile->firstname . ' ' . $userProfile->american_surname }}</h4>
                <p class="mb-0"><em>{{ $userProfile->position->name }}</em></p>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online</span>
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
                        <li><a href="{{ route('admin.roles.index') }}">Role</a></li>
                        @can('view', App\Models\Permission::find(1))
                            <li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
                        @endcan
                    </ul>
                </li>
                <li>
                    @can('viewAny', App\Models\UserProfile::find(1))
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-user-2-line"></i>
                            <span>Administrator</span>
                        </a>
                    @endcan
                    <ul class="sub-menu" aria-expanded="false">
                        @can('view', App\Models\Position::find(1))
                            <li><a href="{{ route('admin.positions.index') }}">Position</a></li>
                        @endcan

                        @can('view', App\Models\Department::find(1))
                            <li><a href="{{ route('admin.departments.index') }}">Departments</a></li>
                        @endcan
                        @can('view', App\Models\UserProfile::find(1))
                            <li><a href="{{ route('admin.user-profiles.index') }}">User Profile</a></li>
                        @endcan

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-group-outline" style="font-size: 22px"></i>
                        <span>Departments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('it-department') }}">IT DEPARTMENT</a></li>
                        <li><a href="{{ route('csr-department') }}">CSR DEPARTMENT</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>HR</span>
                    </a> --}}
                {{-- <ul class="sub-menu" aria-expanded="false">
                        <li class=""><a href="javascript: void(0);" class="has-arrow" aria-expanded="true">Leave
                                Forms</a>
                            <ul class="sub-menu mm-collapse mm-show" aria-expanded="true" style="">
                                <li><a href="javascript: void(0);">Vacation Leave</a></li>
                                <li><a href="javascript: void(0);">Sick Leave</a></li>
                                <li><a href="javascript: void(0);">Emergency Leave</a></li>
                                <li><a href="javascript: void(0);">Birthday Leave</a></li>
                            </ul>
                        </li> --}}
                {{-- <li><a href="{{ route('hrforms.') }}">Memos</a></li> --}}
                {{-- <li><a href="{{ route('hrforms.attendance-records-index') }}">Attendance Records</a></li>
                        <li><a href="javascript: void(0);">Online Monitoring</a></li>
                        <li><a href="{{ route('hrforms.birthday-calendar-index') }}">Birthday Calendar</a></li>
                        <li><a href="{{ route('hrforms.company-handbook') }}">Company Handbook</a></li>
                        <li class=""><a href="javascript: void(0);" class="has-arrow" aria-expanded="true">Other
                                Forms</a>
                            <ul class="sub-menu mm-collapse mm-show" aria-expanded="true" style="">
                                <li><a href="{{ route('hrforms.accountability-form') }}">Accountability Form</a></li>
                                <li><a href="{{ route('hrforms.incident-report-form') }}">Incident Report</a></li>
                                <li><a href="javascript: void(0);">Proposal Form</a></li>
                                <li><a href="javascript: void(0);">Disposal Form</a></li>
                                <li><a href="javascript: void(0);">MoM (Minutes of Meeting) Form</a></li>
                            </ul>
                        </li> --}}
                {{-- </ul>
                </li> --}}

                <li class="menu-title">Sales</li>
                <li>
                    @can('view', App\Models\Lead::find(1))
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-headphone-line"></i>
                            <span>App Taker</span>
                        </a>
                    @endcan

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('apptaker-leads') }}">Lead List</a></li>
                        {{-- <li><a href="{{ route('apptaker-leads') }}">Call Back</a></li> --}}
                        {{-- <li><a href="{{ route('apptaker-leads') }}">Lead List</a></li> --}}
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-clipboard-line"></i>
                        <span>Quotation</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('appointed-leads') }}">For Qoute Leads</a></li>
                        <li><a href="{{ route('assign-appointed-lead') }}">Assign Appointed Leads</a></li>
                        <li><a href="{{ route('get-quoted-product') }}">Assign Quoted Leads</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-briefcase-line"></i>
                        <span>Broker Assistant</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('get-pending-product') }}">Broker Assistant View</a></li>
                        {{-- <li><a href="{{route('get-confirmed-product')}}">Confirmed Product</a></li> --}}
                    </ul>
                </li>

                @can('view', App\Models\Lead::find(1))
                    <li class="menu-title">Leads</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-spy-line"></i>
                            <span>LEADS FUNNEL</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('viewImport', App\Models\Lead::find(1))
                                <li><a href="{{ route('leads') }}">Import Leads</a></li>
                            @endcan
                            @can('viewLeadsFunnel', App\Models\Lead::find(1))
                                <li><a href="{{ route('assign') }}">Assign Leads</a></li>
                            @endcan
                            <li><a href="pages-directory.html">Leads Profile</a></li>
                        </ul>
                    @endcan
                <li class="menu-title">Customer Service</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shopping-cart-line"></i>
                        <span>Binding</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('binding') }}">Products</a></li>
                    </ul>
                </li>

                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
