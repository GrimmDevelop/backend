<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string historical_name
 * @property int real_location_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property \Carbon\Carbon deleted_at
 */
class Location extends Model
{

    protected $fillable = [
        'historical_name',
    ];
}
