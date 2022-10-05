<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Customers', function (Blueprint $table) {
            $table->id();
            $table->string('AccountNumber')->unique();
            $table->string('FirstName');
            $table->string('MiddleName');
            $table->string('LastName');
            $table->string('Suffix');
            $table->string('Address');
            $table->string('MeterNumber');
            $table->string('ConnectionType');
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
        Schema::dropIfExists('Customers');
    }
}
