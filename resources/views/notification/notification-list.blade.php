<style>
    .list-group-item {
        border: none;
        border-bottom: 1px solid #ddd;
    }

    .list-group-item img {
        width: 40px;
        height: 40px;
    }

    .badge.rounded-circle {
        width: 10px;
        height: 10px;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4em 0.6em;
    }

    .btn-sm {
        font-size: 0.8rem;
    }

    .notification-item.unread {

        background-color: #fafbff;
        /* Gray background for read */
        color: #6c757d;
    }

    .notification-item.read {
        background-color: #ffffff;
        /* Dim the text */
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Notifications</h5>
        <a href="#" id="mark-all-read" class="text-primary text-decoration-none">Mark all as read</a>
    </div>
    <div class="list-group">

        {{-- <!-- Notification Item 1 -->
        <div class="list-group-item d-flex justify-content-between align-items-start">
            <div class="d-flex">
                <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="Avatar">
                <div>
                    <p class="mb-0"><strong>Hailey Garza</strong> added new tags to <span class="text-danger">🔥 Ease
                            Design System</span></p>
                    <small class="text-muted">1 min ago · Easy 2023 Project</small>
                    <div class="mt-2">
                        <span class="badge bg-success">UI Design</span>
                        <span class="badge bg-info text-dark">Dashboard</span>
                        <span class="badge bg-secondary">Design system</span>
                    </div>
                </div>
            </div>
            <span class="badge bg-danger rounded-circle align-self-center">&nbsp;</span>
        </div>

        <!-- Notification Item 2 -->
        <div class="list-group-item d-flex justify-content-between align-items-start">
            <div class="d-flex">
                <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="Avatar">
                <div>
                    <p class="mb-0"><strong>Kamron</strong> asked to join <span class="text-danger">🔥 Ease Design
                            System</span></p>
                    <small class="text-muted">1 hour ago · Easy 2023 Project</small>
                    <div class="mt-2">
                        <div class="d-flex">
                            <span class="me-2"><img src="https://via.placeholder.com/20" alt="File Icon"></span>
                            <div>
                                <span class="d-block">Ease Design System.fig</span>
                                <small class="text-muted">Edited 12 mins ago</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-outline-danger btn-sm me-2">Decline</button>
                        <button class="btn btn-outline-success btn-sm">Accept</button>
                    </div>
                </div>
            </div>
            <span class="badge bg-danger rounded-circle align-self-center">&nbsp;</span>
        </div> --}}
    </div>
    <div id="pagination-container" class="text-center"></div>
</div>
<script>
    $(document).ready(function() {
        let currentPage = 1; // Track the current page

        // Mark notification as read when clicked
        $('.list-group-item').on('click', function() {
            $(this).find('.badge.bg-danger').removeClass('bg-danger').addClass('bg-secondary');
        });

        // Handle Accept and Decline buttons
        $('.btn-outline-success').on('click', function() {
            alert('Request Accepted!');
        });

        $('.btn-outline-danger').on('click', function() {
            alert('Request Declined!');
        });

        $(document).on('click', '#load-more-notifications', function() {
            currentPage++;
            fetchAndDisplayNotifications(currentPage);
        });

        fetchAndDisplayNotifications(currentPage);

        function fetchAndDisplayNotifications(page) {
            $.ajax({
                url: "{{ route('get-notification') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    page: page // Send the page number in the POST data
                },
                success: function(response) {
                    appendNotifications(response.data);

                    // If there are more pages, show the "Load More" button
                    if (response.next_page_url) {
                        $('#pagination-container').html(
                            '<button id="load-more-notifications" class="btn btn-primary btn-sm mt-3">Load More</button>'
                        );
                    } else {
                        $('#pagination-container').html(
                            '<p class="text-muted mt-3">No more notifications to load.</p>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching notifications:", error);
                }
            });
        }

        function formatTimestamp(createdAt) {
            const now = new Date();
            const createdDate = new Date(createdAt);
            const diffInMs = now - createdDate; // Difference in milliseconds
            const diffInMinutes = Math.floor(diffInMs / 60000); // Convert to minutes
            const diffInHours = Math.floor(diffInMinutes / 60); // Convert to hours
            const diffInDays = Math.floor(diffInHours / 24); // Convert to days

            if (diffInMinutes < 1) {
                return "Just now";
            } else if (diffInMinutes < 60) {
                return `${diffInMinutes} min${diffInMinutes > 1 ? "s" : ""} ago`;
            } else if (diffInHours < 24) {
                return `${diffInHours} hour${diffInHours > 1 ? "s" : ""} ago`;
            } else if (diffInDays < 7) {
                return `${diffInDays} day${diffInDays > 1 ? "s" : ""} ago`;
            } else {
                // Display the full date if it's older than 7 days
                return createdDate.toLocaleDateString();
            }
        }

        function appendNotifications(notifications) {

            const notificationList = $('.list-group');
            notificationList.empty();
            const baseUrl = "{{ url('/') }}";
            notifications.forEach(function(notification) {

                const isUnread = notification.read_at === null ? 'unread' : 'read';
                const button = notification.read_at === null ?
                    `<button class="btn btn-outline-primary btn-sm mark-as-read" id=${notification.id}>Mark as Read</button>` :
                    '';
                const notificationHtml = `
                <div class="list-group-item d-flex justify-content-between align-items-start notification-item ${isUnread}">
                    <div class="d-flex">
                        <img src="${baseUrl}/${notification.sender_image}" class="rounded-circle me-3" alt="Avatar">
                        <div>
                            <p class="mb-0">
                                <strong>${notification.data.title}</strong>: ${notification.data.description}
                            </p>
                            <small class="text-muted">Lead ID: ${notification.data.lead_id}</small><br>
                            <small class="text-muted"> ${formatTimestamp(notification.created_at)}</small>
                        </div>
                    </div>
                   ${button}
                </div>
            `;

                notificationList.append(notificationHtml);
            });
        }

        $(document).on('click', '.mark-as-read', function() {
            var id = $(this).attr('id');
            var notificationItem = $(this).closest('.notification-item');
            $.ajax({
                url: "{{ route('mark-as-read') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        notificationItem.removeClass('unread').addClass(
                            'read'); // Change styles
                        notificationItem.find('.mark-as-read')
                            .remove(); // Remove the "Mark as Read" button
                        fetchNotificationCount();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error marking notification as read:", error);
                }
            });

        });


        // events need to triger forreal time notification

        Echo.channel('mark-as-read-notification').listen('MarkAsReadNotificationEvent', (e) => {
            fetchAndDisplayNotifications(currentPage);
        });

        Echo.channel('assign-policy-for-renewal').listen('AssignPolicyForRenewalEvent', (e) => {
            fetchAndDisplayNotifications(currentPage);
        });

        Echo.channel('lead-notes-notification').listen('LeadNotesNotificationEvent', (e) => {
            fetchAndDisplayNotifications(currentPage);
        });

        Echo.channel('assign-appointed-lead').listen('AssignAppointedLeadEvent', (e) => {
            fetchAndDisplayNotifications(currentPage);
        });

        Echo.channel('reassign-appointed-lead').listen('ReassignedAppointedLead', (e) => {
            fetchAndDisplayNotifications(currentPage);
        });


    });
</script>
