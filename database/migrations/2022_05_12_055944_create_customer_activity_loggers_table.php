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
        Schema::create('customer_activity_loggers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_ref',10)->nullable(false);
            $table->enum('action',['CREATE','READ','UPDATE','DELETE'])->nullable(false);
            $table->timestamps();
        });

        Schema::table('customer_activity_loggers', function (Blueprint $table) {
            $table->foreign('customer_ref')->references('customer_ref')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_activity_loggers');
    }
};
