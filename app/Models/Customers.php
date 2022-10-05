<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public $appends = [
        'fullname',
    ];

    public function getFullnameAttribute()
    {
        return Str::upper($this->LastName) . ', ' . Str::upper($this->FirstName) . ' ' . Str::upper($this->MiddleName) . ' ' . Str::upper($this->Suffix);
    }

    public function customerBilling()
    {
        return $this->hasMany(CustomerBilling::class, 'CustomerId', 'id');
    }

    public function account()
    {
        return $this->hasOne(User::class, 'CustomerId', 'id');
    }
}
