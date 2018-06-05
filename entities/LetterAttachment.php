<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string entry
 */
class LetterAttachment extends Model
{

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}