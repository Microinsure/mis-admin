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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_id',10)->unique()->nullable(false);
            $table->string('group_name')->nullable(false);
            $table->string('group_description')->nullable(true);
            $table->string('district',12)->nullable(false);
            $table->string('traditional_authority',30)->nullable(false);
            $table->string('village',20)->nullable(true);
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
        Schema::dropIfExists('groups');
    }
};
