@extends('admin.admin_master')
@section('admin')
    <style>
        .dual-list-box .bootstrap-duallistbox-container {
            display: flex;
            justify-content: space-between;
        }

        .dual-list-box .bootstrap-duallistbox-container select {
            height: 300px !important;
            /* Set the height of the box */

            /* Set the width of the box */
            font-size: 14px;
            /* Adjust font size for better readability */
        }

        .dual-list-box .moveall,
        .dual-list-box .removeall {
            background-color: #007bff;
            /* Custom button color */
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .dual-list-box .moveall:hover,
        .dual-list-box .removeall:hover {
            background-color: #0056b3;
            /* Darker shade on hover */
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-duallistbox.min.css') }}">
    <script src="{{ asset('js/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title mb-2">
                                Assign Permission to {{ $role->name }} role
                            </div>
                            <div class="dual-list-box">
                                <form action="{{ route('admin.roles.permissions', $role->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="dual-list-box">
                                            <!-- Dual List Box -->
                                            <select multiple="multiple" id="permissions" name="permissions[]">
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->id }}"
                                                        {{ $role->hasPermission($permission->name) ? 'selected' : '' }}>
                                                        {{ $permission->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Assign Permissions</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#permissions').bootstrapDualListbox({
                nonSelectedListLabel: 'Available Permissions',
                selectedListLabel: 'Assigned Permissions',
                preserveSelectionOnMove: false,
                moveOnSelect: false,
                filterTextClear: 'Show All',
                infoText: 'Showing {0}',
                infoTextEmpty: 'No permissions available',
                infoTextFiltered: '<span class="badge bg-warning">Filtered</span>',
            });
        });
    </script>
@endsection
