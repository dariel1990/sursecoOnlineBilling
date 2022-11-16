@extends('layouts.winbox')
@push('page-css')
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-12">
                        <div class="text-primary p-3">
                            <h4 class="text-primary fw-bold">{{ $customer->fullname }}</h4>
                            <p class="p-0 m-0">Account #: <span class="fw-bold">{{ $customer->AccountNumber }}</span></p>
                            <p class="p-0 m-0">Address: <span class="fw-bold">{{ $customer->Address }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">

                    <div class="col-sm-8">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ $customer->MeterNumber }}</h5>
                                    <p class="text-muted mb-0">Meter Number</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ $customer->ConnectionType }}</h5>
                                    <p class="text-muted mb-0">Connection Type</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card -->
        @if(!$customer->account == null)
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title mb-4">Account Credentials</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Username</th>
                                    <th>:</th>
                                    <td>{{ $customer->account->username }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile</th>
                                    <th>:</th>
                                    <td>{{ $customer->account->ContactNumber }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail</th>
                                    <th>:</th>
                                    <td>{{ $customer->account->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <th>:</th>
                                    <td><span class="badge badge-pill {{ ($customer->account->email_verified_at != null ? 'badge-soft-success' : 'badge-soft-warning' ) }} font-size-11">{{ ($customer->account->email_verified_at != null ? 'Approved' : 'Pending' ) }}</span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->
        @endif
    </div>

    <div class="col-xl-8">

        <div class="row">
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-danger">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-white fw-medium mb-2">Present Reading (Current)</p>
                                <h4 class="mb-0 text-end text-white">{{ number_format($currentBilling->PresentReading, 2, '.', ',') }} kw</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-danger">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-white fw-medium mb-2">Previous Reading (Current)</p>
                                <h4 class="mb-0 text-end text-white">{{ number_format($currentBilling->PreviousReading, 2, '.', ',') }} kw</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-danger">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-white fw-medium mb-2">KILOWATT USED (Current)</p>
                                <h4 class="mb-0 text-end text-white">{{ number_format($currentBilling->KiloWattsUsed, 2, '.', ',') }} kw</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-warning bg-soft">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium mb-2">Total Bill (Current)</p>
                                <h4 class="mb-0 text-end fw-bold"> &#8369; {{ number_format($currentBilling->TotalBill, 2, '.', ',') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card h-100">
            <div class="card-body">
                <h4 class="card-title mb-4">Previous Billings</h4>
                <div class="table-responsive">
                    <table class="table table-nowrap table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-start">Billing Date</th>
                                <th class="text-center">Present Reading</th>
                                <th class="text-center">Previous Reading</th>
                                <th class="text-center">Kilo Watts Used</th>
                                <th class="text-center">Total Bill</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($otherBilling as $otherBillings)
                                <tr>
                                    <td class="text-start"> {{ Carbon\Carbon::parse($otherBillings->BillingPeriodFrom)->format('F d') }} - {{ Carbon\Carbon::parse($otherBillings->BillingPeriodTo)->format('F d, Y') }} </td>
                                    <td class="text-center"> {{ number_format($otherBillings->PresentReading, 2, '.', ',')  }} </td>
                                    <td class="text-center"> {{ number_format($otherBillings->PreviousReading, 2, '.', ',')  }} </td>
                                    <td class="text-center"> {{ number_format($otherBillings->KiloWattsUsed, 2, '.', ',')  }} </td>
                                    <td class="text-center fw-bold"> {{ number_format($otherBillings->TotalBill, 2, '.', ',')  }} </td>
                                    <td class="text-center"> <span class="badge badge-pill badge-soft-success font-size-11">{{ $otherBillings->BillingStatus == 1 ? 'Paid' : 'Pending' }}</span> </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
@push('page-scripts')
    <script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/winbox/winbox.bundle.js') }}"></script>
    <script>
        $(function(){

        });
    </script>
@endpush
<!-- end row -->
@endsection
