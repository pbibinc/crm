@extends('admin.admin_master')
@section('admin')

<style>
    .loader {
        display: inline-block;
        width: 24px;
        height: 24px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3498db;
        border-radius: 50%;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .large-textarea {
        width: 100%;
        height: 500px;
    }
</style>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Attendance Records</h4>
                <p class="card-title-desc">You can see all attendance records for individual or for all.</p>

                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table">
                            <thead>
                            <tr>
                                <th>Company</th>
                                <th data-priority="1">Time In</th>
                                <th data-priority="3">Time Out</th>
                                <th data-priority="1">Break Out</th>
                                <th data-priority="3">Break In</th>
                                <th data-priority="1">Aux In</th>
                                <th data-priority="3">Aux Out</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th><span class="co-name">Google Inc.</span></th>
                                <td>597.74</td>
                                <td>12:12PM</td>
                                <td>14.81 (2.54%)</td>
                                <td>582.93</td>
                                <td>582.93</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- End Page-content -->

<script>

    

</script>

@endsection