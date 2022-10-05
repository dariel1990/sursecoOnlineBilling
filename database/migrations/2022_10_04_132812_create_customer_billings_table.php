<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CustomerBilling', function (Blueprint $table) {
            $table->id();
            $table->integer('CustomerId');
            $table->string('PresentReading')->unique();
            $table->string('PreviousReading');
            $table->string('KiloWattsUsed');
            $table->string('CurrentBill');
            $table->string('Arrears');
            $table->string('TotalBill');
            $table->string('BillingPeriodFrom');
            $table->string('BillingPeriodTo');
            $table->string('BillingStatus')->default(0); // 0 - Pending, 1 - Paid, 2 - Overdue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CustomerBilling');
    }
}
