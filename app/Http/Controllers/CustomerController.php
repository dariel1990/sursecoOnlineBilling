<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\CustomerBilling;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customers::get();

        return view('admin-customer-list', compact('customers'));
    }

    public function customerList()
    {
        if (request()->ajax()) {

            $data = Customers::with(['account'])->get();
            // dd($data);
            return (new DataTables)->of($data)
                ->addColumn('accountNo', function ($record) {
                    return $record->AccountNumber;
                })
                ->addColumn('fullname', function ($record) {
                    return $record->fullname;
                })
                ->addColumn('address', function ($record) {
                    return $record->Address;
                })
                ->addColumn('meterNo', function ($record) {
                    return $record->MeterNumber;
                })
                ->addColumn('connectionType', function ($record) {
                    return $record->ConnectionType;
                })
                ->addColumn('onlineAccount', function ($record) {
                    return '';
                })
                ->addColumn('actions', function ($record) {
                })

                ->make(true);

        }
    }

    public function customerBillingDetails(int $id)
    {
        $customer = Customers::with('account')->where('id', $id)->first();
        $currentBilling = CustomerBilling::whereMonth('BillingPeriodTo', '=', Carbon::now()->month)->where('CustomerId', $id)->first();
        $otherBilling = CustomerBilling::whereNotIn('id', [$currentBilling->id])->where('CustomerId', $id)->orderBy('BillingPeriodFrom', 'DESC')->get();

        return view('admin-customer-billings', compact('currentBilling', 'otherBilling', 'customer'));
    }
}
