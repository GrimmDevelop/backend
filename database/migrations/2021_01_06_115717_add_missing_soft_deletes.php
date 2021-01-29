<?php

use Grimm\LetterApparatus;
use Grimm\LetterComment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->addSoftDelete(LetterApparatus::class);
        $this->addSoftDelete(LetterComment::class);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    protected function addSoftDelete($model)
    {
        $table = (new $model)->getTable();

        Schema::table($table, function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
