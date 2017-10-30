<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string entry
 * @property int|null year
 * @property bool transcription
 * @property int sort
 */
class LetterPrint extends Model
{
    use SoftDeletes;

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
