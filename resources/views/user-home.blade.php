@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Latest Transaction</h4>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">Account #</th>
                                <th class="align-middle">Billing Name</th>
                                <th class="align-middle">Billing Date</th>
                                <th class="align-middle">Total Bill</th>
                                <th class="align-middle">Payment Date</th>
                                <th class="align-middle">Payment Status</th>
                                <th class="align-middle">Payment Method</th>
                                <th class="align-middle">View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2540</a> </td>
                                <td>Neal Matthews</td>
                                <td>Oct - 2022</td>
                                <td>$400</td>
                                <td>October 22, 2022</td>
                                <td><span class="badge badge-pill badge-soft-success font-size-11">Paid</span></td>
                                <td><i class="fab fa-cc-mastercard me-1"></i> Mastercard
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button"
                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                        View Details
                                    </button>
                                </td>
                            </tr>
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
