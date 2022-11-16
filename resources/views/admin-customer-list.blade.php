@extends('layouts.app')
@push('page-css')
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .winbox {
            border-radius: 8px 8px 0 0;
            box-shadow: none;
        }

        .wb-body {
            /* the width of window border: */
            margin: 4px;
            color: #fff;
            background: #131820;
        }

        .swal-text {
            text-align: center;
        }

        .swal-modal {
            width: 350px;
        }

        .swal-footer {
            text-align: center;
        }

        .btn-warning:not([disabled]):not(.disabled).active,
        .btn-warning:not([disabled]):not(.disabled):active,
        .btn-warning:not([disabled]):not(.disabled).hover,
        .btn-warning:not([disabled]):not(.disabled):hover {
            background-color: #f1b44c !important;
            border-color: #f1b44c !important;
        }

        .btn-warning:hover {
            color: #fff !important;
            text-decoration: none;
            cursor: default;
        }

        .btn-success:not([disabled]):not(.disabled).active,
        .btn-success:not([disabled]):not(.disabled):active,
        .btn-success:not([disabled]):not(.disabled).hover,
        .btn-success:not([disabled]):not(.disabled):hover {
            background-color: #34c38f !important;
            border-color: #34c38f !important;
        }

        .btn-success:hover {
            color: #fff !important;
            text-decoration: none;
            cursor: default;
        }

        .btn-danger:not([disabled]):not(.disabled).active,
        .btn-danger:not([disabled]):not(.disabled):active,
        .btn-danger:not([disabled]):not(.disabled).hover,
        .btn-danger:not([disabled]):not(.disabled):hover {
            background-color: #f46a6a !important;
            border-color: #f46a6a !important;
        }

        .btn-danger:hover {
            color: #fff !important;
            text-decoration: none;
            cursor: default;
        }

    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">List of Customers</h4>
                <table class="table align-middle table-nowrap mb-0 dt-responsive w-100" id="customer-list">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle">Account #</th>
                            <th class="align-middle">Account Name</th>
                            <th class="align-middle">Address</th>
                            <th class="align-middle">Meter #</th>
                            <th class="align-middle">ConnectionType</th>
                            <th class="align-middle">Online Account Status</th>
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
    <script src="{{ asset('/assets/libs/winbox/winbox.bundle.js') }}"></script>
    <script>
        $(function(){
            let users = $('#customer-list').DataTable({
                serverSide: false,
                processing: false,
                destroy : true,
                ordering: false,
                language: {
                    processing: '<i class="text-primary fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>',
                },
                ajax : `/admin/customerList`,
                columns : [
                    {
                        class : 'align-middle',
                        data : 'accountNo',
                        name : 'accountNo',
                        searchable: true,
                        orderable: false
                    },
                    {
                        class : 'align-middle',
                        data : 'fullname',
                        name : 'fullname',
                        searchable: true,
                        orderable: false
                    },
                    {
                        class : 'align-middle',
                        data : 'address',
                        name : 'address',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle',
                        data : 'meterNo',
                        name : 'meterNo',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle',
                        data : 'connectionType',
                        name : 'connectionType',
                        searchable: false,
                        orderable: false
                    },
                    {
                        class : 'align-middle text-center',
                        data : 'onlineAccount',
                        name : 'onlineAccount',
                        searchable: false,
                        orderable: false,
                        render : function (_, _, data, row) {
                                if(data.account == null){
                                    return `<a class="btn btn-danger btn-sm btn-rounded" role="alert">
                                                No Account
                                            </a>`;
                                }else{
                                    if(data.account.email_verified_at != null){
                                        return `<a class="btn btn-success btn-sm btn-rounded" role="alert">
                                                Verified
                                            </a>`;
                                    }else{
                                        return `<a class="btn btn-warning btn-sm btn-rounded" role="alert">
                                                Pending
                                            </a>`;
                                    }
                                };
                        },
                    },
                    {
                        class : 'align-middle text-center',
                        data : 'actions',
                        name : 'actions',
                        searchable: false,
                        orderable: false,
                        render : function (_, _, data, row) {
                                return `<button type="button"
                                            class="btn btn-info btn-sm btn-rounded waves-effect waves-light viewAccountBillingDetails"
                                            title="Account Billing Details"
                                            data-toggle="tooltip"
                                            data-name="${data.fullname}"
                                            data-key="${data.id}">
                                            <i class="mdi mdi-card-account-details"></i>
                                        </button>`;
                        },
                    },
                ]
            });

            $(document).on('click', '.viewAccountBillingDetails', function () {
                let accountId = $(this).attr('data-key');
                let accountName = $(this).attr('data-name');

                new WinBox(`Billing Details of ${accountName}`, {
                    root: document.querySelector('.page-content'),
                    class: ["no-min", "no-max", "no-full", "no-move"],
                    url: `/admin/customerBillingDetails/${accountId}`,
                    index : 999999,
                    y: 130,
                    width: window.innerWidth - (window.innerWidth * .08),
                    height: window.innerHeight - (window.innerHeight * .20),
                    background: "#2a3042",
                    x : "center",
                    onclose: function(force){

                    }
                });
            });
        });
    </script>
@endpush
<!-- end row -->
@endsection
