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
        Schema::create('claim_review_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user')->nullable(false);
            $table->string('claim_number',15)->nullable(false);
            $table->enum('stage',['REVIEW','APPROVAL','AUTHORIZATION'])->nullable(false);
            $table->enum('action',['PUSH_UP','PUSH_DOWN']);
            $table->string('comment',200)->nullable(true);
            $table->timestamps();
        });

        Schema::table('claim_review_stages', function (Blueprint $table) {
            $table->foreign('claim_number')->references('claim_number')->on('compesation_claims');
            $table->foreign('user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_review_stages');
    }
};
