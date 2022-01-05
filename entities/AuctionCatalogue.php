<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string entry
 * @property int|null year
 */
class AuctionCatalogue extends Model
{
    use SoftDeletes;

    public function letter(): BelongsTo
    {
        return $this->belongsTo(Letter::class);
    }
}
