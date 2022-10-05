@extends('layouts.app')
@prepend('meta-data')
@endprepend
@prepend('page-css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .select2-container--default .select2-selection--single{
            padding:5px;
            height: 40px;
            font-size: 1em;
            position: relative;
        }
    </style>
@endprepend
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div>
                    <h4 class="page-title">User Management</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="user-list col-9">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class='table table-striped table-centered' id='users-table'>
                                    <thead>
                                        <tr>
                                            <th class='text-uppercase align-middle'>Employee ID</th>
                                            <th class='text-uppercase align-middle'>Fullname</th>
                                            <th class='text-uppercase align-middle'>Office</th>
                                            <th class='text-center text-uppercase align-middle'>User Role</th>
                                            <th class='text-center text-uppercase align-middle'>
                                                actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
            <div class="create-user col-3">
                <h4>Create User for</h4>
                <form id="add-form" >
                    <div class="form-floating mb-3">
                        <select id="employee_select" class="form form-select employee_select" name="Employee_id">
                            <option selected readonly disabled>Select Employee...</option>
                            @foreach($employees as $employee)
                                <option data-id='{{ $employee->Employee_id }}' value="{{ $employee->Employee_id }}">{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                        <div class='text-danger' id="employee_select-error-message"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control username" id="username" name="username" autocomplete="off">
                        <label for="username">USERNAME</label>
                        <div class='text-danger' id="username-error-message"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control password" id="password" name="password" autocomplete="off">
                        <label for="password">PASSWORD</label>
                        <div class='text-danger' id="password-error-message"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="UserRole" aria-label="Floating label select example" name="UserRole">
                                <option value="1">Admin</option>
                                <option selected value="2">User</option>
                            </select>
                            <label for="UserRole">User Role</label>
                        </div>
                    </div>
                    <div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="btnSave">
                                <div class="spinner-border spinner-border-sm text-light d-none" id="save-spinner" role="status">
                                    <span class="sr-only"></span>
                                </div>
                                SAVE NEW USER
                            </button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light d-none" id="btnSaveChanges">
                                <div class="spinner-border spinner-border-sm text-light d-none" id="save-spinner" role="status">
                                    <span class="sr-only"></span>
                                </div>
                                SAVE CHANGES
                            </button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" id="btnClear">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- end row -->

    </div> <!-- container -->
@endsection
@push('page-scripts')
    <script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(function(){
            $('#employee_select').select2();
            $('b[role="presentation"]').hide();
            let users = $('#users-table').DataTable({
                serverSide: false,
                processing: false,
                destroy : true,
                ordering: false,
                language: {
                    processing: '<i class="text-primary fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>',
                },
                ajax : `/super/admin/userList`,
                columns : [
                    {
                        class : 'lead align-middle fw-medium',
                        data : 'Employee_id',
                        name : 'Employee_id',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'lead align-middle fw-medium',
                        data : 'name',
                        name : 'name',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'lead align-middle fw-medium text-center',
                        data : 'office',
                        name : 'office',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'lead align-middle fw-medium text-center',
                        data : 'UserRole',
                        name : 'UserRole',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle text-center',
                        data : 'actions',
                        name : 'actions',
                        searchable: false,
                        orderable: false,
                        render : function (_, _, data, row) {
                            return `
                            <td class='text-center align-middle'>
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm view-user" data-key="${data.id}">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit-user" data-key="${data.id}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-user" data-key="${data.id}">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </div>
                            </td>`;
                        },
                    },
                ]
            });

            $("#btnSave").click((e) => {
                e.preventDefault();

                $("#save-spinner").removeClass("d-none");
                let data = $("#add-form").serialize();
                $.ajax({
                    url: "/super/admin/user/create",
                    method: "POST",
                    data: data,
                    success: function (response) {
                        if(response.success){
                            $('#save-spinner').addClass('d-none');
                            swal({
                                text : 'Successfully added!',
                                icon : 'success',
                                timer : 1500,
                                buttons : false,
                            });
                            users.ajax.reload();
                            $("#btnClear").trigger("click");
                        }
                    },
                    error: function (response) {
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            const inputNames = [
                                "employee_select",
                                "username",
                                "password",
                                "UserRole"
                            ];
                            $.each(inputNames, function (index, value) {
                                if (errors.hasOwnProperty(value)) {
                                    $(`.${value}`).addClass("is-invalid");
                                    $(`#${value}-error-message`).html("");
                                    $(`#${value}-error-message`).append(
                                        `${errors[value][0]}`
                                    );
                                } else {
                                    $(`.${value}`).removeClass("is-invalid");
                                    $(`#${value}-error-message`).html("");
                                }
                            });
                            $("#save-spinner").addClass("d-none");
                        }
                    },
                });
            });

            $(document).on('click', '#btnClear', function () {
                $("#btnSave").removeClass('d-none');
                $("#btnSaveChanges").addClass('d-none');
                $('.form-title').text('Add New Office');

                const inputNames = [
                    "username",
                    "password",
                ];
                $.each(inputNames, function (index, value) {
                    $(`.${value}`).removeClass("is-invalid");
                    $(`#${value}`).val('');
                    $(`#${value}-error-message`).html("");
                });
            });
        });
    </script>
@endpush

