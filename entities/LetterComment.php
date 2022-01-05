<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string entry
 * @property Letter letter
 */
class LetterComment extends Model
{
    use SoftDeletes, TextWithLetterLinks;

    public $guarded = [];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
