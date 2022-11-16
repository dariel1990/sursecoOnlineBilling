<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\CustomerBilling;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerBillingTransactions;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = User::with(['customer', 'customer.customerBilling', 'customer.customerBilling.customerBillTransaction'])->where('id', Auth::user()->id)->first();
        $latestBill = CustomerBilling::whereMonth('BillingPeriodTo', '=', Carbon::now()->month)->where('CustomerId', Auth::user()->id)->first();

        $currentBilling = CustomerBilling::whereMonth('BillingPeriodTo', '=', Carbon::now()->month)->where('CustomerId', Auth::user()->id)->first();
        $otherBilling = CustomerBilling::whereNotIn('id', [$currentBilling->id])->where('CustomerId', Auth::user()->id)->orderBy('BillingPeriodFrom', 'DESC')->get();
        // dd($latestBill);
        return view('user-home', compact('user', 'latestBill', 'currentBilling', 'otherBilling'));
    }

    public function payNow(Request $request)
    {
        $client = new Client();
        $amount = (int)$request->amount."00";
        $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
            'body' => '{"data":{"attributes":{"amount":'.$amount.',"redirect":{"success":"http://127.0.0.1:8000/payment/success/'.$request->billingId.'","failed":"http://127.0.0.1:8000/payment/failed"},"type":"gcash","currency":"PHP"}}}',
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic cGtfdGVzdF9qcno3THNHNGNQSmFiTHBkTUhRM2hqN3E6c2tfdGVzdF9Gb0V4WUZ2Mk40TVNrRGR6QUdTdVhKcGI=',
                'content-type' => 'application/json',
            ],
        ]);


        $result = json_decode($response->getBody(), true);
        $url = $result['data']['attributes']['redirect']['checkout_url'];
        echo "<script>setTimeout(function(){ window.location.href = '".$url."'; }, 3000);</script>";
        return view('user-pay');
    }

    public function paymentSuccess($billingId)
    {
        $customerBilling = CustomerBilling::find($billingId);
        $customerBilling->BillingStatus = "1";
        $customerBilling->save();

        CustomerBillingTransactions::create([
            "BillingId"         => $customerBilling->id,
            "AmountPaid"        => $customerBilling->TotalBill,
            "TransactionDate"   => Carbon::parse($customerBilling->BillingPeriodTo)->addMonth()->subDays(12)->format('Y-m-d'),
            "PaymentMethod"     => "Online",
        ]);

        $msg = "Payment successfully done. Thank you!";
        return Redirect(route('user.home'))->with('msg', $msg);
    }

    public function paymentFailed()
    {
        $msg = "Transaction was canceled.";
        return Redirect(route('user.home'))->with('cancel', $msg);
    }

}
