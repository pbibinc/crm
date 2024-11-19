@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title mb-4"
                            style="display: flex; align-items: center; background-color: #2c3e50; color: #ecf0f1; padding: 10px 20px; border-radius: 5px;">
                            <i class="ri-file-list-3-line" style="font-size: 26px; margin-right: 15px;"></i>
                            <span style="font-weight: 600; letter-spacing: 1px;">LIST OF APPOINTED LEADS</span>
                        </h3>
                        <div>
                            <button type="button" id="bulkRequestForQuote"
                                class="btn btn-primary btn-rounded waves-effect waves-light mb-4" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Button to assign checked Leads to a selected user"
                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);">
                                <i class="ri-user-received-2-line"></i> Request To Quote
                            </button>
                        </div>
                    </div>

                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body" id="appointed-products-content">
                            @include('leads.appointed-products.pagination')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                let page = $(this).attr('href').split('page=')[1];
                fetchPage(page);
            });

            function fetchPage(page) {
                $.ajax({
                    url: "{{ url('leads/appointed-product-list') }}?page=" + page,
                    success: function(data) {
                        $('#appointed-products-content').html(
                            data); // Replace content with new data
                    },
                    error: function() {
                        console.error("Error fetching data.");
                    }
                });
            }



        })
    </script>
@endsection
