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
        Schema::create('premia', function (Blueprint $table) {
            $table->id();
            $table->string('product_code',5)->unique()->nullable(false);
            $table->string('time_length',50)->unuque()->nullable(false);
            $table->integer('time_in_seconds')->nullable(false);
            $table->decimal('amount',18,2)->nullable(false)->default(0.00);
            $table->timestamps();
        });

        Schema::table('premia', function (Blueprint $table) {
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
        Schema::dropIfExists('premia');
    }
};
