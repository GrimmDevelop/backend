<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string entry
 */
class LetterAttachment extends Model
{
    use SoftDeletes;

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}