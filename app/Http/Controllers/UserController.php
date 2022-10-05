<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::get();

        return view('admin-user-list', compact('users'));
    }

    public function userList()
    {
        if (request()->ajax()) {

            $data = User::with(['customer'])->where('UserRole', 1)->get();
            // dd($data);
            return (new DataTables)->of($data)
                ->addColumn('username', function ($record) {
                    return $record->username;
                })
                ->addColumn('email', function ($record) {
                    return $record->Email;
                })
                ->addColumn('accountNo', function ($record) {
                    return $record->customer->AccountNumber;
                })
                ->addColumn('accountName', function ($record) {
                    return $record->customer->fullname;
                })
                ->addColumn('accountStatus', function ($record) {
                    return $record->AccountStatus;
                })
                ->addColumn('contactNo', function ($record) {
                    return $record->ContactNumber;
                })

                ->make(true);

        }
    }

}
