<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangedIndexInLetterPersonRelation extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_person', function (Blueprint $table) {
            $table->dropForeign(['person_id']);

            $table->foreign('person_id')->references('id')->on('persons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_person', function (Blueprint $table) {
            $table->dropForeign(['person_id']);

            $table->foreign('person_id')->references('id')->on('persons');
        });
    }
}
