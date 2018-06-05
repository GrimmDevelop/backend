<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->string('from_location_historical')->nullable()->default(null)
                ->after('from_id');

            $table->string('from_location_derived')->nullable()->default(null)
                ->after('from_location_historical');

            $table->string('to_location_historical')->nullable()->default(null)
                ->after('to_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(
                'from_location_historical',
                'from_location_derived',
                'to_location_historical'
            );

            $table->string('from_source')->nullable()->after('from_id');
        });
    }
}
