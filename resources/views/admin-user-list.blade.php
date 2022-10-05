@extends('layouts.app')
@push('page-css')
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">List of Users</h4>
                <table class="table align-middle table-nowrap mb-0" id="user-list">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle">Username</th>
                            <th class="align-middle">Email Address</th>
                            <th class="align-middle">Account #</th>
                            <th class="align-middle">Account Name</th>
                            <th class="align-middle">Account Status</th>
                            <th class="align-middle">Contact #</th>
                            <th class="align-middle">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>
@push('page-scripts')
    <script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function(){
            let users = $('#user-list').DataTable({
                serverSide: false,
                processing: false,
                destroy : true,
                ordering: false,
                language: {
                    processing: '<i class="text-primary fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>',
                },
                ajax : `/admin/userList`,
                columns : [
                    {
                        class : 'align-middle',
                        data : 'username',
                        name : 'username',
                        searchable: true,
                        orderable: false
                    },
                    {
                        class : 'align-middle',
                        data : 'email',
                        name : 'email',
                        searchable: true,
                        orderable: false
                    },
                    {
                        class : 'align-middle',
                        data : 'accountNo',
                        name : 'accountNo',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle text-center',
                        data : 'accountName',
                        name : 'accountName',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle text-center',
                        data : 'accountStatus',
                        name : 'accountStatus',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle text-center',
                        data : 'contactNo',
                        name : 'contactNo',
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
                                if(data.account == null){
                                    return `<a class="btn btn-warning btn-sm btn-rounded waves-effect waves-light disabled" role="alert">
                                                No Account
                                            </a>`;
                                }else{
                                    return `<button type="button"
                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                                View Details
                                            </button>`;
                                };
                        },
                    },
                ]
            });
        });
    </script>
@endpush
<!-- end row -->
@endsection
