<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_till_1992')->unsigned()->nullable()->default(null);
            $table->integer('id_till_1997')->unsigned()->nullable()->default(null);

            $table->decimal('code', 14, 4);
            $table->boolean('valid')->default(false);

            $table->string('date');

            $table->string('couvert')->nullable();
            $table->boolean('copy_owned');

            $table->string('language', 5)->default('de');
            $table->string('inc')->nullable();
            $table->string('copy')->nullable();

            $table->string('attachment')->nullable();
            $table->string('directory')->nullable();

            $table->string('handwriting_location')->nullable();

            $table->integer('from_id')->unsigned()->nullable();
            $table->string('from_source')->nullable();

            $table->string('from_date')->nullable();
            $table->string('receive_annotation')->nullable();

            $table->string('reconstructed_from')->nullable();

            $table->integer('to_id')->unsigned()->nullable();
            $table->string('to_date')->nullable();
            $table->string('reply_annotation')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->string('deleted_reason')->nullable()->default(null);


            $table->foreign('from_id')->references('id')->on('locations');
            $table->foreign('to_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letters');
    }
}
