@php
    use App\Models\Lead;
    use App\Models\Callback;
    use Carbon\Carbon;
@endphp

<div class="modal fade" id="viewLeadModal" tabindex="-1" aria-labelledby="viewLeadModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeadsModalLabel">Add Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="leadsLink">

                </div>
            </div>
        </div>
    </div>
</div>

<header id="page-topbar">

    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logopbibinc.png') }}" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logopbibinc.png') }}" alt="logo-dark" height="20">
                    </span>
                </a>
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logopbibinc.png') }}" alt="logo-sm-light"
                            height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logopbibinc.png') }}" alt="logo-light" height="70">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block" id="searchLead">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="ri-search-line"></span>
                </div>
            </form>

        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <form class="p-3" id="searchBarForm">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            @php
                $lead = new Lead();
                $callBack = new Callback();
                $callBackData = $callBack->getCallBackToday();
                $todayCount = $callBackData->count();
            @endphp

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="ri-phone-line"></i>
                    <span>{{ $todayCount ? $todayCount : '' }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="">
                    @foreach ($callBackData as $data)
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">
                                        {{ $data->company_name }}
                                    </h6>
                                    <div class="font-size-12 text-muted">
                                        <!-- Additional text or elements can go here if needed -->
                                    </div>
                                </div>

                            </div>
                        </a>
                    @endforeach

                </div>
            </div>

            @include('partials.notification')

            @php
                $user = Auth::user();
                $id = $user->id;
                $adminData = App\Models\User::find($id);
                $userProfile = $user->userProfile;
            @endphp

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset($userProfile->media->filepath) }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ $adminData->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i>
                        Profile</a>
                    <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My
                        Wallet</a>
                    <a class="dropdown-item d-block" href="#"><span
                            class="badge bg-success float-end mt-1">11</span><i
                            class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i>
                        Lock screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="ri-settings-2-line"></i>
                </button>
            </div>


        </div>

    </div>


</header>
<script>
    $(document).ready(function() {
        $('#searchLead').on('submit', function(e) {
            var url = "{{ env('APP_FORM_LINK') }}";
            e.preventDefault();
            $('#viewLeadModal').modal('show');

            $.ajax({
                url: "{{ route('get-leads-by-search-data') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    search: $(this).find('input').val()
                },
                success: function(data) {
                    var leads = Array.isArray(data) ? data : [data];
                    $('#leadsLink').empty();
                    var table = $(
                        '<table class="table table-bordered"><thead><tr><th>Name</th><th>Phone</th><th>Customer Name</th></tr></thead><tbody></tbody></table>'
                    );
                    console.log(leads);
                    leads[0].leads.forEach(function(lead) {
                        var row = $('<tr></tr>');
                        row.append('<td>' + lead.company_name + '</td>');
                        row.append('<td>' + lead.tel_num + '</td>');
                        row.append(lead.general_information ? '<td>' + lead
                            .general_information.firstname + ' ' + lead
                            .general_information.lastname + '</td>' :
                            '<td>No Profile</td>')
                        row.append((function() {
                            if (lead.general_information) {
                                return '<td><a href="' +
                                    url +
                                    'appointed-list/' + lead
                                    .id +
                                    '" target="_blank">View</a></td>'
                            } else if (lead.deleted_at) {
                                return '<td>DNC Number</td>'
                            } else {
                                return '<td>No Profile</td>'
                            }
                        })());
                        table.find('tbody').append(row);
                    });
                    $('#leadsLink').append(table);
                },
                error: function(err) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Lead not found',
                        icon: 'error'
                    })
                }
            });
        });
    });
</script>
