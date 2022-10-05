<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
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

                ->make(true);

        }
    }
}
