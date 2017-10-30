<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 *
 * @property int id_till_1992
 * @property int id_till_1997
 *
 * @property float code
 * @property bool valid
 *
 * @property string date
 *
 * @property string couvert
 * @property bool copy_owned
 *
 * @property string language
 * @property string inc
 * @property string copy
 *
 * @property string attachment
 * @property string directory
 *
 * @property string handwriting_location
 *
 * @property int from_id
 * @property string from_source
 * @property string from_date
 * @property string receive_annotation
 * @property string reconstructed_from
 *
 * @property int to_id
 * @property string to_date
 * @property string reply_annotation
 *
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 *
 * @property \Carbon\Carbon deleted_at
 * @property string deleted_reason
 *
 * @property Location from
 * @property Location to
 *
 * @property \Illuminate\Support\Collection|LetterPersonAssociation[] personAssociations
 */
class Letter extends Model
{

    use SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drafts()
    {
        return $this->hasMany(Draft::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facsimiles()
    {
        return $this->hasMany(Facsimile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function information()
    {
        return $this->hasMany(LetterInformation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personAssociations()
    {
        return $this->hasMany(LetterPersonAssociation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prints()
    {
        return $this->hasMany(LetterPrint::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function senders()
    {
        return $this->personAssociations->filter(function (LetterPersonAssociation $association) {
            return $association->isSender();
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function receivers()
    {
        return $this->personAssociations->filter(function (LetterPersonAssociation $association) {
            return $association->isReceiver();
        });
    }
}
