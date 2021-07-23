<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFullNameToPersonsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('full_name')->nullable()->default(null)->after('last_name');
        });

        DB::statement('ALTER TABLE persons DROP INDEX fx_person_name');
        DB::statement('CREATE FULLTEXT INDEX fx_person_name ON persons (full_name, first_name, last_name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            DB::statement('ALTER TABLE persons DROP INDEX fx_person_name');
            DB::statement('CREATE FULLTEXT INDEX fx_person_name ON persons (first_name, last_name)');

            $table->dropColumn('full_name');
        });
    }
}
