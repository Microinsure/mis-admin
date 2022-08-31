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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('customer_ref', 10)->nullable(false)->unique();
            $table->string('name');
            $table->string('msisdn');
            $table->enum('gender',['Male', 'Female'])->nullable(false);
            $table->date('dob');
            $table->string('relationship', 50);
            $table->timestamps();
        });

        // Create foreign key on customer_ref field
        // Schema::table('beneficiaries', function (Blueprint $table) {
        //     $table->foreign('customer_ref')->references('customers')->on('customer_ref');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiaries');
    }
};
