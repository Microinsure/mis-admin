<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('txn_internal_reference',20)->unique()->nullable(false);
            $table->string('txn_external_reference',20)->unique()->nullable(false);
            $table->string('txn_account_number',15)->nullable(false);
            $table->decimal('txn_amount',18,2)->nullable(false)->default(0.00);
            $table->string('txn_description',200)->nullable(true);
            $table->unsignedBigInteger('txn_channel')->nullable(false);
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('txn_account_number')->references('account_number')->on('accounts');
            $table->foreign('txn_channel')->references('id')->on('transaction_channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
