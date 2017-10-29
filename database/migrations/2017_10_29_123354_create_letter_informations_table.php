<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetterInformationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_informations', function (Blueprint $table) {
            $table->increments('id');

            $table->text('data');
            $table->integer('letter_code_id')->unsigned();
            $table->integer('letter_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('letter_code_id')->references('id')->on('letter_codes')->onDelete('cascade');
            $table->foreign('letter_id')->references('id')->on('letters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_informations');
    }
}
