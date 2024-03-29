<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBilling extends Model
{
    use HasFactory;
    protected $table = 'customerbilling';

    protected $fillable = [
        'CustomerId',
        'PresentReading',
        'PreviousReading',
        'KiloWattsUsed',
        'CurrentBill',
        'Arrears',
        'TotalBill',
        'BillingPeriodFrom',
        'BillingPeriodTo',
        'BillingStatus',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'CustomerId', 'id');
    }

    public function customerBillTransaction()
    {
        return $this->hasOne(CustomerBillingTransactions::class, 'BillingId', 'id');
    }
}
