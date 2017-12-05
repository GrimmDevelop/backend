<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacsimilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facsimiles', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('letter_id')->unsigned();

            $table->string('entry');

            $table->integer('year')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('facsimiles');
    }
}
