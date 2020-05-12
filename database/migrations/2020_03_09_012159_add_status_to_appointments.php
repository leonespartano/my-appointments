<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToAppointments extends Migration
{
    /**
     * Migración empleada para actualizar la tabla appointments.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            //reservada, confirmada, atendida, cancelada.
            $table->string('status')->default('Reservada');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            //reservada, confirmada, atendida, cancelada.
            $table->dropColumn('status');
        });
    }
}
