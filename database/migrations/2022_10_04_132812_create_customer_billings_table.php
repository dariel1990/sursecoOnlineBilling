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
            $table->integer('PresentReading');
            $table->integer('PreviousReading');
            $table->integer('KiloWattsUsed');
            $table->decimal('CurrentBill', 11,2);
            $table->decimal('Arrears', 11,2);
            $table->decimal('TotalBill', 11,2);
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
