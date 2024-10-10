<div class="row">
    <table id="complied" class="table table-bordered dt-responsive nowrap complied"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Quoted By</th>
            <th>Appointed By</th>
            <th>Broker</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.complied').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-broker-complied-product') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'quotedBy',
                    name: 'quotedBy'
                },
                {
                    data: 'appointedBy',
                    name: 'appointedBy'
                },
                {
                    data: 'complianceOfficer',
                    name: 'complianceOfficer'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        // $(document).on('click', '.viewButton', function() {
        //     var id = $(this).attr('id');
        //     console.log(id);
        // });
    });
</script>
