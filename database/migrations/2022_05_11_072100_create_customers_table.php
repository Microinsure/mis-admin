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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_ref',10)->unique()->nullable(false);
            $table->string('firstname',15)->nullable('false');
            $table->string('middlename',30)->nullable(true);
            $table->string('lastname',15)->nullable(false);
            $table->enum('gender', ['MALE','FEMALE'])->nullable(false);
            $table->string('msisdn',15)->unique()->nullable(false);
            $table->string('email',40)->unique()->nullable(true);
            $table->string('address',250)->nullable(true);
            $table->string('pin',255)->nullable(false);
            $table->enum('status',['UNVERIFIED','ACTIVE','SUSPENDED','DELETED'])->nullable(false)->default('UNVERIFIED');
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
        Schema::dropIfExists('customers');
    }
};
