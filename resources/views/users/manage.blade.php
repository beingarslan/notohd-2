@extends('layouts/contentLayoutMaster')

@section('title', 'Users')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('content')

<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddModel">
                        <i data-feather='user-plus'></i>
                    </button>
                </div>
                <div class="card body">
                    <table id="users-table" class="datatables-basic table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New User Model -->
    <div class="modal fade" id="AddModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Add User Information</h1>
                        <!-- <p>Updating user details will receive a privacy audit.</p> -->
                    </div>
                    <form id="editUserForm" class="row gy-1 pt-75" action="{{route('admin.users.save')}}" method="POST">
                        @csrf
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserFirstName">Name</label>
                            <input type="text" id="modalEditUserFirstName" name="name" class="form-control" placeholder="Name" value="" data-msg="Please enter your first name" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserLastName">Email</label>
                            <input type="email" id="modalEditUserLastName" name="email" class="form-control" placeholder="Email" value="" data-msg="Please enter your last name" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName">Password</label>
                            <input type="password" id="modalEditUserName" name="password" class="form-control" value="" placeholder="Password" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName">Confirm Password</label>
                            <input type="password" id="modalEditUserName" name="password_confirmation" class="form-control" value="" placeholder="Confirm Password" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserStatus">Status</label>
                            <select id="modalEditUserStatus" name="status" class="form-select" aria-label="Default select example">
                                <option selected value="" >Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserCountry">Role</label>
                            <select id="modalEditUserCountry" name="role" class="select2 form-select">
                                <option selected value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role}}">{{$role}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Discard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New User Model End -->

</section>
<!--/ Basic table -->

@endsection


@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')


<script>
    $(function() {
        $('#users-table').DataTable({
            responsive: false,
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.users.users") !!}',
            columns: [


                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    render: function(data) {
                        return '<b>' + data + '</b>'
                    }
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    render: function(data) {
                        if(data == "Admin"){
                            return '<span class="badge badge-glow bg-success">Admin</span>'

                        }
                        else{
                            return '<span class="badge badge-glow bg-info">User</span>'
                        }
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        if (data) {
                            return '<span class="badge badge-glow bg-primary">Active</span>'
                        } else {
                            return '<span class="badge badge-glow bg-primary">InActive</span>'
                        }
                    }
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ]
        });
    });
</script>

@endsection
