<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed entry
 * @property mixed year
 */
class Facsimile extends Model
{

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
