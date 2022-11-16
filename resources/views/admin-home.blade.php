@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p>Admin Dashboard</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{ asset('assets/images/surseco.png') }}" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">NEMSU Cantilan</h5>
                        <p class="text-muted mb-0 text-truncate">UI/UX Designer</p>
                    </div>

                    <div class="col-sm-8">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-12">
                                    <h5>BETA VERSION RELEASED!</h5>
                                    <p>Good Day! This Web App is currently a BETA Version. Data used are all sample data. Complete version will be released soon!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-transparent border-bottom text-uppercase lead fw-bold">Total Collections Online</div>
            <div class="card-body bg-success bg-soft">
                <div class="row">
                    <div class="col-sm-4 text-end">
                        <p class="text-muted font-size-16">Month of <br>October</p>
                    </div>
                    <div class="col-sm-8 text-center">
                        <p class="h1">&#8369; 34,252.00</p>
                        <p class="text-muted mb-3">32 Transactions</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary waves-effect waves-light w-sm">
                                <i class="mdi mdi-eye d-block font-size-16"></i> View All Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Registered Users</p>
                                <h4 class="mb-0">{{ $registeredUsers }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                        <i class="bx bx-user-pin font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Business Type Connections</p>
                                <h4 class="mb-0">{{ $customerBusinessCon }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bxs-business font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Residential Type Connections</p>
                                <h4 class="mb-0">{{ $customerResidentialCon }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-home-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex flex-wrap">
                    <h4 class="card-title mb-4">Email Sent</h4>
                    <div class="ms-auto">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Week</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Month</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Year</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex flex-wrap">
                    <h4 class="card-title mb-4">Latest Transaction</h4>
                    <div class="ms-auto">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="btn btn-primary text-white" href="#">View all Transactions</a>
                            </li>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">Account #</th>
                                <th class="align-middle">Billing Name</th>
                                <th class="align-middle">Billing Date</th>
                                <th class="align-middle">Total Bill</th>
                                <th class="align-middle">Payment Date</th>
                                <th class="align-middle">Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customerTransactions as $customerTransaction)
                                <tr>
                                    <td>{{ $customerTransaction->customerBill->customer->AccountNumber }}</td>
                                    <td>{{ $customerTransaction->customerBill->customer->fullname }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customerTransaction->customerBill->BillingPeriodTo)->format('M d, Y') }}</td>
                                    <td>{{ number_format($customerTransaction->customerBill->TotalBill, 2, '.', ',') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customerTransaction->TransactionDate)->format('M d, Y')}}</td>
                                    <td>
                                        <span class="badge badge-pill {{ $customerTransaction->PaymentMethod == 'Online' ? 'badge-soft-success' : 'badge-soft-warning'}} font-size-11">
                                        {{ $customerTransaction->PaymentMethod }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@endsection
