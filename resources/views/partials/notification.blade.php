@php
    use App\Models\Lead;
    use App\Models\Callback;
    use Carbon\Carbon;
    use App\Models\UserProfile;
@endphp
<style>
    .custom-notification-dropdown .dropdown-menu {
        width: 400px !important;
        /* Use !important to enforce the width */
        min-width: 400px !important;
        /* Ensure the width doesn't shrink */
        max-width: 400px !important;
        /* Prevent it from growing too wide */
    }

    .custom-notification-dropdown .notification-item h6 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 280px;
        /* Adjust this to fit within your design */
    }

    .custom-notification-dropdown .notification-item .text-muted {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 280px;
        /* Adjust accordingly */
    }

    .custom-notification-dropdown .avatar-xs {
        width: 35px;
        height: 35px;
    }

    .custom-notification-dropdown .avatar-title {
        font-size: 16px;
    }

    .custom-notification-dropdown [data-simplebar] {
        overflow-y: auto;
        max-height: 230px;
    }

    .custom-notification-dropdown .notification-item .d-flex {
        align-items: center;
    }

    .custom-notification-dropdown .notification-item .flex-1 {
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="dropdown d-inline-block custom-notification-dropdown">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-notification-3-line"></i>
        <span class="noti-dot"></span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> Notifications </h6>
                </div>
                <div class="col-auto">
                    <a href="#!" class="small"> View All</a>
                </div>
            </div>
        </div>
        <div data-simplebar style="max-height: 230px;">

        </div>
        <div class="p-2 border-top">

            <div class="d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    var userId = {{ auth()->id() }}
    $.ajax({
        url: "{{ route('get-notification') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function(response) {
            console.log(response.data);
            appendNotifications(response.data);
        }
    })

    function appendNotifications(notifications) {
        const notificationContainer = $('.custom-notification-dropdown [data-simplebar]');
        notificationContainer.empty(); // Clear existing notifications
        const baseUrl = "{{ url('/') }}";
        $.each(notifications, function(index, notification) {
            let notificationItem = '';
            let avatarContent = '';
            let link = '#';
            let title = ' ';
            let description = ' '


            // Determine the avatar content based on notification type and image availability
            if (notification['type'] === 'App\\Notifications\\LeadNotesNotification' || notification['type'] ===
                'App\\Notifications\\GeneralNotification') {
                avatarContent =
                    `<img src="${baseUrl}/${notification['sender_image']}" class="me-3 rounded-circle avatar-xs" alt="user-pic">`;
                link = notification.link || '#';

                title = notification['data']['title'] || ' ';
                description = notification['data']['description'] || ' ';
            } else {
                let iconClass = '';
                if (notification['type'] === 'App\\Notifications\\AssignAppointedLead') {
                    iconClass = 'mdi-account-arrow-left-outline';
                    title = notification['data']['message'] || ' ';
                    description = notification['data']['message'] || ' ';
                } else if (notification['type'] === 'App\\Notifications\\ReassignAppointedLeadNotification') {
                    iconClass = 'mdi-account-arrow-right-outline';
                    title = notification['data']['message'] || ' ';
                    description = notification['data']['message'] || ' ';

                } else if (notification['type'] === 'App\\Notifications\\AssignPolicyForRenewalNotification') {
                    iconClass = 'mdi-autorenew';
                    title = notification['data']['message'] || ' ';
                    description = notification['data']['message'] || ' ';

                }
                avatarContent =
                    `<span class="avatar-title rounded-circle font-size-16"><i class="mdi ${iconClass}"></i></span>`;
            }

            // Construct the notification item based on type
            notificationItem = `
            <a href="${link}" class="text-reset notification-item">
                <div class="d-flex">
                    <div class="avatar-xs me-3">
                        ${avatarContent}
                    </div>
                    <div class="flex-1">
                        <h6 class="mb-1">${title}</h6>
                        <div class="font-size-12 text-muted">${description}</div>
                    </div>
                </div>
            </a>
        `;

            // Append the constructed HTML to the container
            notificationContainer.append(notificationItem);
        });
    }
</script>
