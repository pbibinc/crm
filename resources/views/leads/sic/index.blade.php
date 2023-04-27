@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

<!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"></h4>
                </div>
            </div>
        </div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPositionModal" id="addDispositionType">
                        ADD SIC TYPES</a>
                        {{-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a> --}}
                </div>
                <h4 class="card-title mb-4">Standard Industrial Classification</h4>
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Classcode ID</th>
                                <th>SIC Code</th>
                                <th>Workers' Comp. Code</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
</div>

{{-- start of modal for creation and edition--}}
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="dataModalLabel">Add SIC</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="dataModalForm">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Select Classcode</label>
                {{-- <input type="text" class="form-control" id="sic_classcode" name="sic_classcode" required> --}}
                <select class="form-select" aria-label="Default select example" id="sic_classcode" name="sic_classcode">
                    {{-- <option selected="">Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option> --}}
                    @foreach($classcodes as $classcode)
                    <option value="{{ $classcode->id }}">{{ $classcode->classcode_name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">SIC Code</label>
                <input type="text" class="form-control" id="sic_code" name="sic_code" required>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Workers' Comp. Code</label>
                <input type="text" class="form-control" id="sic_wccode" name="sic_wccode" required>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Description (Optional)</label>
                <textarea class="form-control" style="resize:none;" rows="4" cols="50" id="sic_description" name="sic_description"></textarea>
              </div>
              <input type="hidden" name="action" id="action" value="add">
              <input type="hidden" name="hidden_id" id="hidden_id" />
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-primary">
          </div>
        </form>
        </div>
      </div>
    </div>
</div>
{{-- end of modal --}}


{{-- start of deletion of modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" >
          <h5 class="modal-title"><b>Confirmation</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to remove this data?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">Confirm</button>
        </div>
      </div>
    </div>
  </div>
{{-- end of deletion of modal --}}

<script>

    // Initialize Yajra DT
    $(document).ready(function() {
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('sic.index') }}",
            columns: [
                {data: "id"},
                {data: "classcode_name"},
                {data: "sic_code"},
                {data: "workers_comp_code"},
                {data: "description"},
                {data: "created_at_formatted"},
                {data: "updated_at_formatted"},
                {data: "action", orderable: false, searchable: false},
            ]
        });
    });

    // configuring of modal for adding new entry
    $("#addDispositionType").on("click", function () {
        $(".modal-title").text("Add New Record");
        $("#action_button").val("Add");
        $("#action").val("Add");
        $("#dataModal").modal("show");
    });

    // When submitting form 
    $("#dataModalForm").on("submit", function (event) {
        event.preventDefault();

        // Get submit button value
        var action_url = '';
        if ($("#action").val() == "Add") {
            action_url = "{{ route('sic.store') }}";
        } 
        if ($("#action").val() == "Update") {
            action_url = "{{ route('sic.update') }}";
        }

        // Collect your form data
        var formData = {
            "_token": "{{ csrf_token() }}",
            "sic_classcode": $("#sic_classcode").val(),
            "sic_code": $("#sic_code").val(),
            "workers_comp_code": $("#sic_wccode").val(),
            "description": $("#sic_description").val(),
        };

        // AJAX Request
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: action_url,
            type: "POST",
            data: formData,
            beforeSend: function () {
                $('#action').text('Please wait...');
                $('#action').attr('disabled', true);
            },
            success: function (response) {
                $("#dataModal").modal("hide");
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var errors = jqXHR.responseJSON;
                console.log(errors);
            },
            complete: function (textStatus, errorThrown) {
                $('#action').removeAttr('disabled');
                console.log("AJAX request failed", textStatus, errorThrown);

            }
        });
    });
    // end submitting new entry

    // script for configuring edit modal
    $(document).on('click', '.edit', function(event){ 
        event.preventDefault();
        var id = $(this).attr('id');
        console.log(id);
        $('#form_result').html;
        $.ajax({
            url: "/leads/sic/"+id+"/edit",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            dataType:"json",
            // beforeSend: function () {
            //     $('#action').text('Please wait...');
            //     $('#action').attr('disabled', true);
            // },
            success:function(data){
                $('#sic_classcode').val(data.result.sic_classcode);
                $('#sic_code').val(data.result.sic_code);
                $('#sic_wccode').val(data.result.workers_comp_code);
                $('#sic_description').val(data.result.description);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Update');
                $('#dataModal').modal('show');
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
            },
            // complete: function (textStatus, errorThrown) {
            //     $('#action').removeAttr('disabled');
            //     console.log("AJAX request failed", textStatus, errorThrown);
            // }
        });
     });

    //script for deletion
    var sic_id
    $(document).on('click', '.delete', function(){
        // console.log('test');
        sic_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    //script for sending delete
    $('#ok_button').click(function(){
        $.ajax({
            type:'DELETE',
            url:"/leads/sic/" + sic_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting.....');
            },
            success:function($data)
            {
                setTimeout(() => {
                    $('#confirmModal').modal('hide');
                    location.reload();
                }, 1000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                console.log('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
</script>


@endsection