<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->string('contract_name');
            $table->string('contract_number');
            $table->bigInteger('department_id')->default(0);
            $table->unsignedBigInteger('company_id');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->string('regimen_id');
            $table->string('site');
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
        Schema::dropIfExists('contracts');
    }
}
