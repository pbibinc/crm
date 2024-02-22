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

    Echo.channel('declined-make-payment-request').listen('DeclinedRequest', (e) => {
        const leadId = e.leadId;
        const generalInformationId = e.generalInformationId;
        const productId = e.productId;
        console.log('test this code for echo listner')
        Push.create('Payment Request Declined', {
            body: `Payment request for lead ${leadId} has been declined`,
            onClick: function() {
                window.focus();
                window.open(
                    `/quoatation/broker-profile-view/${leadId}/${generalInformationId}/${productId}`,
                )
                this.close();
            }
        });
    })

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
        if (userId == notifyId) {
            Push.create('New Request For Quotation', {
                body: `You have been assigned a new lead`,
                onClick: function() {
                    window.focus();
                    window.open(`/appointed-list`, '_blank');
                    this.close();
                }
            });
        }
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
        console.log(e);
        var notifyId = e.userId;
        var noteTitle = e.noteTitle;
        var noteDescription = e.noteDescription;
        var leadId = e.leadId;
        if (userId == notifyId) {
            Push.create(`${noteTitle}`, {
                body: `${noteDescription}`,
                onClick: function() {
                    window.focus();
                    window.open(`/appointed-list/${leadId}`, '_blank');
                    this.close();
                }
            });
        }
    });

    let notificationQueue = [];
    let processingQueue = false;

    function displayToast(notification) {
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
                icon: "success",
                title: "Policy " + notification.policy + " is due for renewal"
            }).then(() => {
                resolve();
            });
        });
    }

    function processNotificationQueue() {
        if (notificationQueue.length > 0) {
            const notification = notificationQueue.shift(); // Get the first notification from the queue
            processingQueue = true;

            displayToast(notification).then(() => {
                processingQueue = false; // Reset the processing flag
                processNotificationQueue(); // Attempt to process the next notification
            });
            Push.create('Policy For Renewal', {
                body: `Policy ${notification.policy} is due for renewal`,
                onClick: function() {
                    window.focus();
                    window.open(`/customer-service/renewal/renewal`, '_blank');
                    this.close();
                }
            });
        }
    }

    Echo.channel('assign-policy-for-renewal').listen('AssignPolicyForRenewalEvent', (e) => {
        var notifyId = e.userId;
        var policy = e.policy;
        if (userId == notifyId) {
            notificationQueue.push({
                policy: policy
            });

            if (!processingQueue) {
                processNotificationQueue();
            }
        }
    });

    var yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
</script>
