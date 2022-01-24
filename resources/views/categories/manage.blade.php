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
                        Add Category
                    </button>
                </div>
                <div class="card-body">
                    <table id="users-table" class="datatables-basic table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Title</th>
                                <th>Parent</th>
                                <th>No. Of Child</th>
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
                        <h1 class="mb-1">Add Category Information</h1>
                        <!-- <p>Updating user details will receive a privacy audit.</p> -->
                    </div>
                    <form id="editUserForm" class="row gy-1 pt-75" action="{{route('admin.categories.save')}}" method="POST">
                        @csrf
                        <div class="col-12">
                            <label class="form-label" for="modalEditUserFirstName">Title</label>
                            <input type="text" id="modalEditUserFirstName" name="title" class="form-control" placeholder="Title" value="" data-msg="Please enter your first name" />
                        </div>
                        <!-- description -->
                        <div class="col-12">
                            <label class="form-label" for="modalEditUserLastName">Description</label>
                            <textarea name="description" id="modalEditUserLastName" class="form-control" placeholder="Description" data-msg="Please enter your last name"></textarea>
                        </div>
                        <!-- parent -->
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserEmail">Parent (optional)</label>
                            <select name="parent_id" id="modalEditUserEmail" class="form-control" data-msg="Please enter your email address">
                                <option value="">Select Parent</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserStatus">Status</label>
                            <select id="modalEditUserStatus" name="status" class="form-select" aria-label="Default select example">
                                <option selected value="">Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
            ajax: '{!! route("admin.categories.categories") !!}',
            columns: [


                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    render: function(data) {
                        return '<b>' + data + '</b>'
                    }
                },
                {
                    data: 'parent',
                    name: 'parent'
                },
                {
                    data: 'child',
                    render: function(data) {
                            return '<span class="badge bg-primary">'+data+'</span>'
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        if (data) {
                            return '<span class="badge badge-glow bg-primary">Active</span>'
                        } else {
                            return '<span class="badge badge-glow bg-warning">InActive</span>'
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
