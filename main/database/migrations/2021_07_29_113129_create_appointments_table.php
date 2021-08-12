<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('call_id')->default(0);
            $table->bigInteger('space_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->enum('state', ['Aperturada', 'Cancelado', 'Atendido'])->nullable()->default('Aperturada');
            $table->string('diagnostico', 50)->nullable();
            $table->string('professional_id', 50)->nullable();
            $table->string('ips_id', 50)->nullable();
            $table->string('speciality_id', 50)->nullable();
            $table->string('speciality', 50)->nullable();
            $table->string('procedure', 50)->nullable();
            $table->string('date', 50)->nullable();
            $table->string('origin', 50)->nullable();
            $table->string('procedure_id', 50)->nullable();
            $table->string('price', 50)->nullable();
            $table->string('observation', 50)->nullable();
            $table->string('reason_cancellation')->nullable();
            $table->dateTime('cancellation_at')->nullable();
            $table->timestamps();
            $table->string('ips')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('link', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
