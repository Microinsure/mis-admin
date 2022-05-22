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
        Schema::create('s_m_s_advisories', function (Blueprint $table) {
            $table->id();
            $table->string('product_code',5)->nullable(false);
            $table->string('title',20)->nullable(false);
            $table->string('message',165)->nullable(false);
            $table->unsignedBigInteger('author')->nullable(false);
            $table->integer('recipients_count');
            $table->enum('approal',['PENDING','APPROVED'])->default('PENDING');
            $table->enum('status',['PENDING','SENT','CANCELLED','DELETED'])->default('PENDING');
            $table->timestamps();
        });

        Schema::table('s_m_s_advisories', function (Blueprint $table) {
            $table->foreign('product_code')->references('product_code')->on('insurance_products');
            $table->foreign('author')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_m_s_advisories');
    }
};
