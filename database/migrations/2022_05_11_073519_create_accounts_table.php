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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number',15)->unique()->nullable(false);
            $table->string('account_name',50)->nullable(false);
            $table->unsignedBigInteger('account_type');
            $table->enum('account_status',['ACTIVE','FROZEN'])->nullable(false)->default('ACTIVE');
            $table->timestamps();
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->foreign('account_type')->references('id')->on('account_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
