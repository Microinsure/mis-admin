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
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->string('customer_ref',10)->nullable(false);
            $table->string('group_id',10)->nullable(false);
            $table->timestamps();
        });

        Schema::table('group_members', function (Blueprint $table) {
            $table->foreign('customer_ref')->references('customer_ref')->on('customers');
            $table->foreign('group_id')->references('group_id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_members');
    }
};
