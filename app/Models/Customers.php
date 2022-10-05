<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'AccountNumber',
        'FirstName',
        'MiddleName',
        'LastName',
        'Suffix',
        'Address',
        'MeterNumber',
        'ConnectionType',
    ];

    public function customerBilling()
    {
        return $this->hasMany(CustomerBilling::class, 'CustomerId', 'id');
    }

    public function user()
    {
        return $this->hasOne(Users::class, 'CustomerId', 'id');
    }
}
