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
        Schema::create('insurance_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code',5)->unique()->nullable(false);
            $table->string('product_name',50)->unuque()->nullable(false);
            $table->string('product_description',200)->nullable(true);
            $table->enum('status',['AVAILABLE','SUSPENDED'])->default('AVAILABLE');
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
        Schema::dropIfExists('insurance_products');
    }
};
