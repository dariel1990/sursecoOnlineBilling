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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Accomplishments</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Calendar</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="d-grid mb-4">
                                    <button class="btn btn-lg font-16 btn-success" id="print-summary"><i
                                        class="mdi mdi-printer"></i> Print Accomplishment
                                    </button>
                                </div>
                                <div class="card">
                                    <div class="card-body border-secondary border">
                                        <h4 >ACCOMPLISHMENT SUMMARY</h4>
                                        <hr >
                                        <table class="table table-hovered bg-light" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle" width="80%">Service Category</th>
                                                    <th class="text-center align-middle" width="20%">No of Services</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($summary as $sum)
                                                    <tr>
                                                        <td class="align-middle">{{ $sum->description }}</td>
                                                        <td class="text-center align-middle">{{ $sum->services }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="align-middle">Total Services Delivered</th>
                                                    <th class="text-center align-middle">{{ $countAccomplishment }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-9">
                                <div class="mt-4 mt-lg-0">
                                    <h3>Accomplishment by Employee</h3>
                                    <table class="table table-sm bg-light" width="100%">
                                        @foreach($employees as $employee)
                                            @php 
                                                    $summaryByEmployees = Illuminate\Support\Facades\DB::table('accomplishments')
                                                                ->selectRaw("categories.description, COUNT('accomplishments.*') as services")
                                                                ->where('accomplishments.user_id', $employee->id)
                                                                ->join('categories', 'categories.id', '=', 'accomplishments.category')
                                                                ->groupBy('categories.description')
                                                                ->get();
                                                    $countAccomplishment = App\Models\Accomplishments::where('user_id',  $employee->id)->count();
                                                @endphp
                                            <tr>
                                                <td class="fw-bold" colspan="2">{{ $employee->lastname . ', ' . $employee->firstname . ' ' . substr($employee->middlename, 0, 1) }}</td>
                                                <td class="fw-bold text-end">Total Services Rendered</td>
                                                <td class="fw-bold">{{ $countAccomplishment }}</td>
                                            </tr>
                                            @foreach($summaryByEmployees as $summaryByEmployee)
                                            <tr>
                                                <td></td>
                                                <td>{{ $summaryByEmployee->description }}</td>
                                                <td>{{ $summaryByEmployee->services }}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </div>
                            </div> <!-- end col -->

                        </div> <!-- end row -->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
            <!-- Add New Event MODAL -->
                <div class="modal fade" id="print-modal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form class="needs-validation" name="event-form" id="form-print" novalidate>
                                @csrf
                                <div class="modal-header py-3 px-4 border-bottom-0">
                                    <h5 class="modal-title" id="modal-title">Print Accomplishment Summary</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-4 pb-4 pt-0">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label for="print-from" class="form-label">From</label>
                                                <input class="form-control" id="print-from" type="month" name="print-from" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label for="print-to" class="form-label">To</label>
                                                <input class="form-control" id="print-to" type="month" name="print-to" required>
                                            </div>
                                        </div>
                                        <div class="d-grid mt-2">
                                            <button type="button" class="btn btn-lg font-16 btn-success" id="print-now"><i
                                                class="mdi mdi-printer"></i> Print Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end modal-content-->
                    </div> <!-- end modal dialog-->
                </div>
                <!-- end modal-->
            <!-- end col-12 -->
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
    
