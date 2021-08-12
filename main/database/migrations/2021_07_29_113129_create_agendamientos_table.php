<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamientos', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('type_agenda_id')->nullable();
            $table->integer('type_appointment_id')->nullable();
            $table->integer('ips_id')->nullable();
            $table->integer('eps_id')->nullable();
            $table->integer('speciality_id')->nullable();
            $table->integer('person_id')->nullable();
            $table->string('date_start', 20)->nullable();
            $table->string('date_end', 20)->nullable();
            $table->string('long', 5)->nullable();
            $table->string('hour_start', 20)->nullable();
            $table->string('hour_end', 20)->nullable();
            $table->json('days')->nullable();
            $table->tinyInteger('pending')->nullable()->default(0);
            $table->enum('state', ['Agendado', 'Cancelado'])->default('Agendado');
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
        Schema::dropIfExists('agendamientos');
    }
}
