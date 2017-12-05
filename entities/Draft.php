<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string entry
 * @property int year
 */
class Draft extends Model
{

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
