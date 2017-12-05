<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetterPersonAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_person', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('letter_id')->unsigned();
            $table->integer('person_id')->unsigned()->nullable();

            $table->string('assignment_source');

            // 0: Sender, 1: Receiver, 2: Mentioned
            $table->tinyInteger('type');

            $table->timestamps();

            $table->foreign('letter_id')->references('id')->on('letters')->onDelete('cascade');

            // There must not be a 'on delete cascade' modifier on the persons,
            // because we do not want to delete the assignment_source fields, if a person
            // is deleted. This is different when deleting a letter.
            $table->foreign('person_id')->references('id')->on('persons');

            $table->unique(['letter_id', 'person_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_person');
    }
}
