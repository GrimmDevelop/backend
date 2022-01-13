<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PrefillPeopleNameFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Grimm\Person::query()->whereNull('full_name')->orWhere('full_name', '')->update([
            'full_name' => DB::raw('last_name'),
        ]);

        \Grimm\Person::query()->whereNull('full_first_name')->orWhere('full_first_name', '')->update([
            'full_first_name' => DB::raw('first_name'),
        ]);
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
}
