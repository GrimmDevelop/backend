<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string entry
 * @property int|null year
 */
class AuctionCatalogue extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
