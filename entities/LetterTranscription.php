<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string entry
 * @property int year
 * @property int sort
 */
class LetterTranscription extends Model
{

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}