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
        Schema::create('staff_activity_loggers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->enum('action',['CREATE','READ','UPDATE','DELETE'])->nullable(false);
            $table->string('description', 255)->nullable(false);
            $table->timestamps();
        });

        Schema::table('staff_activity_loggers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_activity_loggers');
    }
};
