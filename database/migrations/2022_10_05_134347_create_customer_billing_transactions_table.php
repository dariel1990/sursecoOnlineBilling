<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBillingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CustomerBillingTransactions', function (Blueprint $table) {
            $table->id();
            $table->integer('BillingId');
            $table->decimal('AmoutPaid', 11,2);
            $table->dateTime('TransactionDate');
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
        Schema::dropIfExists('CustomerBillingTransactions');
    }
}
