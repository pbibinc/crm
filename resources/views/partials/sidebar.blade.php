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
                <h4 class="font-size-16 mb-1">{{ $userProfile->american_name }}</h4>
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
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    </ul>
                </li>

                <li>
                    <a href="{{ route('dashboard-report') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>Report</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-tools-fill"></i>
                        <span>PDF Tools</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('pdf-editor.index') }}">PDF Editor</a></li>
                        <li><a href="{{ route('ocr-pdf.index') }}">OCR PDF</a></li>
                        <li><a href="{{ route('pdf-workflow.index') }}">PDF Workflow</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-tools-fill"></i>
                        <span>Email Tools</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('single-email-validator.index') }}">Single Email Validator</a></li>
                        <li><a href="{{ route('batch-email-validator.index') }}">Batch Email Validator</a></li>
                    </ul>
                </li>

                @can('view', App\Models\Permission::find(1))
                    <li class="menu-title">Admin</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class=" ri-currency-line"></i>
                            <span>Accounting</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('accounting-payable') }}">Accounts Receivable</a></li>
                            <li><a href="{{ route('payment-for-charged') }}">Accounts Payable</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-lock-line"></i>
                            <span>Security</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.users.index') }}">User Accounts</a></li>
                            <li><a href="{{ route('admin.roles.index') }}">User Role</a></li>
                            <li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
                        </ul>
                    </li>
                    <li>
                        @can('viewAny', App\Models\UserProfile::find(1))
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-user-2-line"></i>
                                <span>Administrators</span>
                            </a>
                        @endcan
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view', App\Models\Position::find(1))
                                <li><a href="{{ route('admin.positions.index') }}">User Position</a></li>
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
                            <i class="ri-spy-line"></i>
                            <span>Leads Funnel</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('viewImport', App\Models\Lead::find(1))
                                <li><a href="{{ route('leads') }}">Import Lead Records</a></li>
                            @endcan
                            <li><a href="{{ route('leads-dnc-view') }}">DNC Database</a></li>
                            @can('viewLeadsFunnel', App\Models\Lead::find(1))
                                <li><a href="{{ route('assign') }}">Lead Distribution</a></li>
                            @endcan
                            <li><a href="{{ route('website.index') }}">Website List</a></li>
                            {{-- <li><a href="pages-directory.html">Leads Profile</a></li> --}}
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-brush-2-line"></i>
                            <span>Marketing</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.marketingtemplate.index') }}">Templates</a></li>
                            <li><a href="#">Campagains</a></li>
                            <li><a href="#">Market List</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-group-outline" style="font-size: 22px"></i>
                            <span>Departments</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin-department') }}">Admin Department</a></li>
                            <li><a href="{{ route('csr-department') }}">CSR Department</a></li>
                            <li><a href="{{ route('sales-department') }}">Sales Department</a></li>
                            <li><a href="{{ route('quotation-department') }}">Quotation Department</a></li>
                        </ul>
                    </li>

                @endcan
                @can('viewAnySales', App\Models\Lead::find(1))
                    <li class="menu-title">Sales</li>
                    <li>
                        @can('viewAnyApptaker', App\Models\Lead::find(1))
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-headphone-line"></i>
                                <span>App Takers</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('viewApptakerLeadList', App\Models\Lead::find(1))
                                    <li><a href="{{ route('apptaker-leads') }}">Lead Dashboard</a></li>
                                @endcan
                                @can('viewApptakerLeadListAppointed', App\Models\Lead::find(1))
                                    <li><a href="{{ route('appointed-list') }}">Appointed Lead List</a></li>
                                @endcan
                                <li><a href="{{ route('appointed-product-list.index') }}">Leads per Product</a></li>

                                @can('viewCallBackLeadList', App\Models\Lead::find(1))
                                    <li><a href="{{ route('callback-lead') }}">Call-Back Queue</a></li>
                                @endcan
                                <li><a href="{{ route('non-callback-disposition') }}">Dispositioned Leads</a></li>
                                <li><a href="#">Insurance Need Survey</a></li>
                            </ul>
                        @endcan
                    </li>
                    <li>
                        @can('viewAnyQuotation', App\Models\Lead::find(1))
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-clipboard-line"></i>
                                <span>Quote Specialist</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('viewAssignApppointedLeads', App\Models\Lead::find(1))
                                    <li><a href="{{ route('assign-appointed-lead') }}">Assign Qualified Leads</a></li>
                                @endcan
                                @can('viewForQouteLeads', App\Models\Lead::find(1))
                                    <li><a href="{{ route('appointed-leads') }}">Leads for Quoting</a></li>
                                @endcan

                                <li><a href="{{ route('market-list.index') }}">Market List</a></li>
                                <li><a href="{{ route('insurer') }}">Carrier List</a></li>
                            </ul>
                        @endcan
                    </li>
                    <li>
                        @can('viewAnyBrokerAssistant', App\Models\Lead::find(1))
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-briefcase-line"></i>
                                <span>Broker Assist</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('viewAssignQuotedLeads', App\Models\Lead::find(1))
                                    <li><a href="{{ route('get-quoted-product') }}">Assign Quoted Leads</a></li>
                                @endcan
                                @can('viewBrokerAssistantLeadList', App\Models\Lead::find(1))
                                    <li><a href="{{ route('broker-assistant.index') }}">Quoted Leads Distribution</a></li>
                                    <li><a href="{{ route('leads-for-follow-up.index') }}">Follow-Up Calls</a></li>
                                    <li><a href="{{ route('broker-assist-leads-log.index') }}">Leads Logs</a></li>
                                @endcan
                                {{-- <li><a href="{{route('get-confirmed-product')}}">Confirmed Product</a></li> --}}
                            </ul>
                        @endcan
                    </li>
                @endcan
                <li class="menu-title">Broker</li>
                <li>
                    @can('viewAnyBrokerAssistant', App\Models\Lead::find(1))
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-briefcase-line"></i>
                            <span>Primary Leads</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('viewBrokerAssistantLeadList', App\Models\Lead::find(1))
                                <li><a href="{{ route('product.index') }}">Direct New Leads</a></li>
                            @endcan
                            @can('viewBrokerAssistantLeadList', App\Models\Lead::find(1))
                                <li><a href="{{ route('product.index') }}">Direct Renewal Leads</a></li>
                            @endcan
                            {{-- <li><a href="{{route('get-confirmed-product')}}">Confirmed Product</a></li> --}}
                        </ul>
                    @endcan
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-settings-2-line"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('assign-agent-to-broker.index') }}">Assigning Agent</a></li>
                    </ul>
                </li>
                {{-- @can('view', App\Models\Lead::find(1))
                    <li class="menu-title">Leads</li>
                @endcan --}}

                @can('viewAnyCustomerService', App\Models\Lead::find(1))
                    <li class="menu-title">Customer Service</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-shopping-cart-line"></i>
                            <span>Online Forms</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('quotation-form.index') }}">Quote Form Lists</a></li>
                            <li><a href="{{ route('insurance-needs-survey-form.index') }}">Insurance Survey Form
                                    Lists</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-shopping-cart-line"></i>
                            <span>Binding</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('binding') }}">Bind Queue</a></li>
                            <li><a href="{{ route('policy-list') }}">Policy List</a></li>
                            <li><a href="{{ route('customer-account-setting.index') }}">Customer Account Setting</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class=" ri-hand-heart-line
                            "></i>
                            <span>Financing</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('financing-agreement.index') }}">Fiancing Agreement</a></li>
                            <li><a href="{{ route('finance-agreement-list.index') }}">PFA Records</a></li>
                            <li><a href="{{ route('financing-company.index') }}">Financing Companies</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-cancel"></i>
                            <span>Cancellation</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('primary-cancellation.index') }}">Primary CCN</a></li>
                            <li><a href="{{ route('request-cancellation.index') }}">Cancellation Request</a></li>
                            <li><a href="{{ route('cancelled-policy.index') }}">Cancelled Policy List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-recycle-variant"></i>
                            <span>Recovery</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            <li><a href="{{ route('rewrite-policy.index') }}">Recovery/Rewrite</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-autorenew"></i>
                            <span>Renewal Department</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            {{-- <li><a href="{{ route('renewal.index') }}">Assign For Quote Renewal</a></li> --}}
                            <li><a href="{{ route('assign-quoted-policy.index') }}">Assign Renewal Policies</a></li>
                            <li><a href="{{ route('for-renewal.index') }}">Renewal Quoting</a></li>
                            <li><a href="{{ route('renewal-policy.index') }}">Policy For Renewal</a></li>
                            <li><a href="{{ route('old-renewal-policy.index') }}">Old Renewal</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-autorenew"></i>
                            <span>Certificate</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('certificate.index') }}">Certificate Request</a></li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
