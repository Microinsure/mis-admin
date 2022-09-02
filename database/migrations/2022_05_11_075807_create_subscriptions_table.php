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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('account_number',15)->nullable(false);
            $table->string('product_code',5)->nullable(false);
            $table->enum('subscription_type',['INDIVIDUAL','GROUP'])->nullable(true);
            $table->decimal('amount',18,2)->nullable(false)->default(0.00);
            $table->date('startdate')->nullable(false);
            $table->enum('payment_status',['PENDING','PAID','DEFAULTED'])->nullable(false)->default('PENDING');
            $table->enum('claim_status',['UNACLAIMED','CLAIMED'])->nullable(false)->default('UNACLAIMED');
            $table->enum('disbursement_status',['PENDING','DISBURSED','FAILED'])->nullable(false)->default('PENDING');
            $table->enum('validity', ['PENDING', 'ACTIVE', 'EXPIRED'])->default('PENDING');
            $table->timestamps();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('account_number')->references('account_number')->on('accounts');
            $table->foreign('product_code')->references('product_code')->on('insurance_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
