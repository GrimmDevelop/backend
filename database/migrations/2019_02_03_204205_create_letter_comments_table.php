<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterCommentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('letter_id')->unsigned();

            $table->text('entry');

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
        Schema::dropIfExists('letter_comments');
    }
}
