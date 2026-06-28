<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountexamtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countexamtimes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_soal', 150);
            $table->string('id_user', 15);
            $table->string('waktu', 25);
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
        Schema::drop('countexamtimes');
    }
}
