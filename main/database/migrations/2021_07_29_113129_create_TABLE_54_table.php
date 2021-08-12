<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTABLE54Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TABLE 54', function (Blueprint $table) {
            $table->string('nit', 11)->nullable();
            $table->string('institution_name', 58)->nullable();
            $table->string('patient_id', 10)->nullable();
            $table->string('patient_name', 37)->nullable();
            $table->string('speciality', 32)->nullable();
            $table->string('observations', 87)->nullable();
            $table->string('timestamp', 26)->nullable();
            $table->integer('id', true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TABLE 54');
    }
}
