<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealLocationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_locations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('feature_code', 5);
            $table->decimal('latitude', 7, 5);
            $table->decimal('longitude', 7, 5);

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
        Schema::dropIfExists('real_locations');
    }
}
