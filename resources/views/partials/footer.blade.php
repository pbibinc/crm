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

    var yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
</script>
