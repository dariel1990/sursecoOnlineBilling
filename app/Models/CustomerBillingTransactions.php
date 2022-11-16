<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBillingTransactions extends Model
{
    use HasFactory;
    protected $table = 'CustomerBillingTransactions';

    protected $fillable = [
        'BillingId',
        'AmountPaid',
        'TransactionDate',
        'PaymentMethod',
    ];

    public function customerBill()
    {
        return $this->belongsTo(CustomerBilling::class, 'BillingId', 'id');
    }
}
