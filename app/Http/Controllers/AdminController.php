<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\CustomerBilling;
use App\Models\CustomerBillingTransactions;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //Dashboard Pills
        $registeredUsers = Customers::Has('account')->count();
        $customerBusinessCon = Customers::where('ConnectionType', 'Business')->count();
        $customerResidentialCon = Customers::where('ConnectionType', 'Residential')->count();

        $currentBilling = CustomerBilling::whereMonth('BillingPeriodTo', '=', Carbon::now()->month)->first();

        $customerTransactions = CustomerBillingTransactions::with(['customerBill', 'customerBill.customer'])->orderBy('TransactionDate', 'DESC')->get()->take(10);

        return view('admin-home', compact('customerTransactions', 'registeredUsers', 'customerBusinessCon', 'customerResidentialCon'));
    }
}
