<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetterPrintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_prints', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('letter_id')->unsigned();

            $table->string('entry');
            $table->integer('year')->nullable();
            $table->boolean('transcription')->default(false);


            $table->integer('sort')->default(0);

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('letter_prints');
    }
}
