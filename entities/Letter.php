<?php

namespace Grimm;

use App\Grid\Grid;
use App\Grid\Gridable;
use App\Grid\IsGridable;
use Grimm\Grids\LetterGrid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Sofa\Eloquence\Eloquence;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\Media;

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
 * @property \Illuminate\Support\Collection|LetterPrint[] prints
 * @property \Illuminate\Support\Collection|Draft[] drafts
 * @property \Illuminate\Support\Collection|Facsimile[] facsimiles
 */
class Letter extends Model implements IsGridable, HasMedia
{

    use SoftDeletes, HasActivity, Gridable, HasMediaTrait, Eloquence;

    protected $searchableColumns = [
        // 'from.historical_name' => 16,
        // 'to.historical_name' => 16,
        'personAssociations.assignment_source' => 15,
        'prints.entry' => 5,
        'drafts.entry' => 3,
        'facsimiles.entry' => 3,
        'information.data' => 3,
        'handwriting_location' => 2,
    ];

    /**
     * Returns full title of letter
     *
     * @return string
     */
    public function title()
    {
        $title = '#' . $this->id;

        if ($senders = $this->senders()) {
            $title .= ' ' . $senders->map(function (LetterPersonAssociation $association) {
                    return $association->assignment_source;
                })->implode(' / ');
        }

        if ($receivers = $this->receivers()) {
            $title .= ' an ' . $receivers->map(function (LetterPersonAssociation $association) {
                    return $association->assignment_source;
                })->implode(' / ');
        }

        if ($this->from) {
            $title .= ' aus ' . $this->from->historical_name;
        }

        if ($this->to) {
            $title .= ' nach ' . $this->to->historical_name;
        }

        return $title;
    }

    /**
     * Returns field for scan collection
     *
     * @param $collection
     * @return mixed
     */
    public function fieldForCollection($collection)
    {
        if (Str::contains($collection, '.')) {
            list($relation, $id) = explode('.', $collection);

            return $this->{$relation}()->where('id', $id)->first()->entry;
        }

        return $this->{$collection};
    }

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
        })->values();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function receivers()
    {
        return $this->personAssociations->filter(function (LetterPersonAssociation $association) {
            return $association->isReceiver();
        })->values();
    }

    public function scopeByPerson(Builder $query, $personId, $type)
    {
        return $query->whereHas('personAssociations', function ($query) use ($personId, $type) {
            $query->where('person_id', $personId);

            if ($type !== null) {
                $query->where('type', $type);
            }
        });
    }

    public function grid(): Grid
    {
        return new LetterGrid($this);
    }

    public function resortCollection($collection)
    {
        $ids = $this->getMedia($collection)->pluck('id')->toArray();

        Media::setNewOrder($ids);
    }
}
