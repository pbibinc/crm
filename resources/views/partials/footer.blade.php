<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div id="yearContainer" style="display:flex">
                    <span id="year"></span> © IT DEPARTMENT INSURAPRIME.
                </div>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Crafted with <i class="mdi mdi-heart text-danger"></i> by InsuraPrime Dev
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ mix('/js/app.js') }}"></script>
<script>
    var userId = {{ auth()->id() }};



    //dial pad ringing event
    Echo.channel('calls').listen('CallRinging', (e) => {
        const leadId = e.leadId;
        window.open(`/appointed-list/${leadId}`, '_blank');
    });

    Echo.channel('assign-appointed-lead-notification').listen('.AssignAppointedLead', (notification) => {
        alert('test this notification');
        console.log('test this notification');
    });

    Echo.channel('assign-appointed-lead').listen('AssignAppointedLeadEvent', (e) => {
        var notifyId = e.userId;
        enqueueNotification(e, 'New Request For Quotation', 'You have been assigned a new lead',
            `/appointed-list`);
        // if (userId == notifyId) {
        //     Push.create('New Request For Quotation', {
        //         body: `You have been assigned a new lead`,
        //         onClick: function() {
        //             window.focus();
        //             window.open(`/appointed-list`, '_blank');
        //             this.close();
        //         }
        //     });
        // }
    });

    Echo.channel('reassign-appointed-lead').listen('ReassignedAppointedLead', (e) => {
        if (e.oldUserId = userId) {
            Push.create(`Product Reassign to ${e.receivableName}`, {
                body: `Your Product Has been reassigned to ${e.receivableName}`,
                onClick: function() {
                    window.focus();
                    window.open(`/appointed-list`, '_blank');
                    this.close();
                }
            });
        } else if (e.newUserId = userId) {
            Push.create('New Request For Quotation', {
                body: `New Product Request For Quotation`,
                onClick: function() {
                    window.focus();
                    window.open(`/appointed-list`, '_blank');
                    this.close();
                }
            });
        }
    });


    Echo.channel('lead-notes-notification').listen('LeadNotesNotificationEvent', (e) => {
        var notifyId = e.userId;
        var noteTitle = e.noteTitle;
        var noteDescription = e.noteDescription;
        var leadId = e.leadId;
        var icon = e.icon;

        enqueueNotification(e, noteTitle, noteDescription, `/appointed-list/${leadId}`, icon);
    });

    let notificationQueue = [];
    let processingQueue = false;

    Echo.channel('assign-policy-for-renewal').listen('AssignPolicyForRenewalEvent', (e) => {
        enqueueNotification(e, "Policy For Renewal", `Policy ${e.policy} is due for renewal`,
            '/customer-service/renewal/for-renewal');
    });

    function enqueueNotification(eventData, title, message, link, icon) {
        var notifyId = eventData.userId;
        if (userId == notifyId) { // Ensure `userId` is defined and relevant to your logic
            notificationQueue.push({
                title,
                message,
                link,
                icon
            });
            if (!processingQueue) {
                processNotificationQueue();
            }
        }
    }


    function processNotificationQueue() {
        if (notificationQueue.length > 0 && !processingQueue) {
            const notification = notificationQueue.shift(); // Get the first notification from the queue
            processingQueue = true;

            let message = notification.message; // Assume these are now passed directly
            let title = notification.title;
            let icon = notification.icon;
            displayToast(message, title, icon).then(() => {
                processingQueue = false; // Reset the processing flag
                processNotificationQueue(); // Attempt to process the next notification
            });

            Push.create(title, {
                body: message,
                onClick: function() {
                    window.focus();
                    window.open(notification.link, notification.link);
                    this.close();
                }
            });


        }
    }


    function displayToast(message, title, icon) {
        return new Promise((resolve) => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 6000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: title,
            }).then(() => {
                resolve();
            });
        });
    }


    var yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
</script>
