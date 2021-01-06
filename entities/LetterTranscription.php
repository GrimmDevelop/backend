<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string entry
 * @property int year
 * @property int sort
 */
class LetterTranscription extends Model
{
    use SoftDeletes;

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}