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
        Schema::create('compesation_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_number',15)->unique()->nullable(false);
            $table->unsignedBigInteger('subscription_id')->nullable(false);
            $table->unsignedBigInteger('customer_id')->nullable(false);
            $table->decimal('amount',18,2)->nullable(false)->default(0.00);
            $table->enum('processing_stages',['REVIEW','APPROVAL','AUTHORIZATION','COMPLETED']);
            $table->enum('status',['PENDING','HONORED','REJECTED'])->nullable(false)->default('PENDING');
            $table->string('comment',255)->nullable(true);
            $table->timestamps();
        });

        Schema::table('compesation_claims', function (Blueprint $table) {
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compesation_claims');
    }
};
