<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string entry
 * @property Letter letter
 */
class LetterApparatus extends Model
{

    public $guarded = [];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
