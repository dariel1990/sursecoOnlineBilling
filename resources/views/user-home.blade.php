@extends('layouts.user-app')

@section('content')
<div class="row">
    <div class="col-xl-5">
        <!-- end card -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @if(session()->has('msg'))
                        <div class="alert alert-success">
                            {{ session()->get('msg') }}
                        </div>
                    @endif
                    @if(session()->has('cancel'))
                        <div class="alert alert-warning">
                            {{ session()->get('cancel') }}
                        </div>
                    @endif
                    <div class="col-sm-7">
                        <span class="lead text-muted">Current Billing</span>
                        <p class="m-2 h1">&#8369; {{ number_format($latestBill->TotalBill, 2, ".", ",") }}</p>
                        <small class="text-muted font-size-14">From {{ \Carbon\Carbon::parse($latestBill->BillingPeriodFrom)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($latestBill->BillingPeriodTo)->format('M d, Y') }}</small>
                    </div>
                    <div class="col-sm-5">
                        <div class="d-grid">
                            @if($latestBill->BillingStatus == "0")
                                <form method="POST" action="{{ route("user.paynow") }}">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ $latestBill->TotalBill }}">
                                    <input type="hidden" name="billingId" value="{{ $latestBill->id }}">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-sm p-4 shadow-lg">
                                        <i class="fab fa-gofore d-block font-size-24"></i> Pay Now thru GCASH
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-success w-sm p-4 font-size-24 text-center">
                                    Paid
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-12">
                        <div class="text-primary p-3">
                            <h4 class="text-primary fw-bold">{{ $user->customer->fullname }}</h4>
                            <p class="p-0 m-0">Account #: <span class="fw-bold">{{  $user->customer->AccountNumber }}</span></p>
                            <p class="p-0 m-0">Address: <span class="fw-bold">{{  $user->customer->Address }}</span></p>
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
                                    <h5 class="font-size-15">{{  $user->customer->MeterNumber }}</h5>
                                    <p class="text-muted mb-0">Meter Number</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15">{{  $user->customer->ConnectionType }}</h5>
                                    <p class="text-muted mb-0">Connection Type</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-7">

        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-danger">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-white fw-medium mb-2">Present Reading</p>
                                <h4 class="mb-0 text-end text-white">{{ number_format($currentBilling->PresentReading, 2, '.', ',') }} kw</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-danger">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-white fw-medium mb-2">Previous Reading</p>
                                <h4 class="mb-0 text-end text-white">{{ number_format($currentBilling->PreviousReading, 2, '.', ',') }} kw</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body bg-danger">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-white fw-medium mb-2">KILOWATT USED</p>
                                <h4 class="mb-0 text-end text-white">{{ number_format($latestBill->KiloWattsUsed, 2, '.', ',') }} kw</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Previous Billings</h4>
                <div class="table-responsive">
                    <table class="table table-nowrap table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-start">Billing Period</th>
                                <th class="text-center">Present</th>
                                <th class="text-center">Previous</th>
                                <th class="text-center">KW Used</th>
                                <th class="text-center">Total Bill</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($otherBilling as $otherBillings)
                                <tr>
                                    <td class="text-start"> {{ Carbon\Carbon::parse($otherBillings->BillingPeriodFrom)->format('M d') }} - {{ Carbon\Carbon::parse($otherBillings->BillingPeriodTo)->format('M d, Y') }} </td>
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

@endsection
