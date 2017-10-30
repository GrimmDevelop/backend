<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

class Facsimile extends Model
{

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
