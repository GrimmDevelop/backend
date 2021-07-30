<?php

use Grimm\Letter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutgoingNoticeFieldToLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->string('outgoing_notice')->nullable()->default(null)->after('from_date');
        });

        /** @var \Grimm\LetterCode $code */
        $code = \Grimm\LetterCode::query()->where('name', 'ausg_notiz')->first();

        if (!$code) {
            return;
        }

        \Grimm\Letter::query()->whereHas('information', function (Builder $q) use ($code) {
            $q->where('letter_code_id', $code->id);
        })->with(['information' => function (HasMany $q) use ($code) {
            $q->where('letter_code_id', $code->id);
        }])->chunk(100, function ($letters) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($letters) {
                /** @var Letter $letter */
                foreach ($letters as $letter) {
                    $letter->outgoing_notice = $letter->information->first()->data;
                    $letter->save();
                }
            });
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
            $table->dropColumn('outgoing_notice');
        });
    }
}
