@extends('layouts.app')
@prepend('meta-data')
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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            

                        </div> <!-- end row -->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
        </div> <!-- end row -->

    </div> <!-- container -->
@endsection
@push('page-scripts')
    <script>
        $(function () {
            let printModal = new bootstrap.Modal(document.getElementById("print-modal"), {
                backdrop: "static"
            });
            let btnPrintNow = $("#print-now");  

            btnPrintNow.click(() => {
                let from = $('#print-from').val();
                let to = $('#print-to').val();
                if(from === "" || to === ""){
                    $('#print-from').addClass('is-invalid');
                    $('#print-to').addClass('is-invalid');
                    swal({
                        title : 'Warning!',
                        text : 'Please fill out required fields.',
                        icon : 'warning',
                        timer : 1000,
                        buttons : false,
                    });
                }else{
                    window.open(`/admin/print-by-cat/${from}/${to}`);   
                    window.open(`/admin/print-summary/${from}/${to}`);
                }
            });

            $('#print-summary').click(() => {
                printModal.show();
            });

        });
    </script>
@endpush
    
