<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('agendamiento_id')->nullable()->index('agendamiento_id');
            $table->string('hour_start', 20)->nullable();
            $table->bigInteger('person_id')->nullable();
            $table->string('className', 50)->nullable();
            $table->string('hour_end', 20)->nullable();
            $table->string('long', 20)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->string('backgroundColor', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spaces');
    }
}
