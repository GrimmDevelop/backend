<?php

namespace Grimm;

use App\Grid\Grid;
use App\Grid\Gridable;
use App\Grid\IsGridable;
use Carbon\Carbon;
use Grimm\Grids\LetterGrid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int id
 * @property string unique_code
 *
 * @property int id_till_2018
 * @property int id_till_1992
 * @property int id_till_1997
 *
 * @property float code
 * @property bool valid
 *
 * @property string text
 * @property string date
 *
 * @property string addition
 * @property string couvert
 * @property bool copy_owned
 *
 * @property string language
 * @property string inc
 * @property string copy
 *
 * @property string directory
 *
 * @property string handwriting_location
 *
 * @property int from_id
 * @property string from_location_historical
 * @property string from_location_derived
 * @property string from_date
 * @property string receive_annotation
 * @property string reconstructed_from
 *
 * @property int to_id
 * @property string to_location_historical
 * @property string to_date
 * @property string reply_annotation
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Carbon deleted_at
 * @property string deleted_reason
 *
 * @property Location from
 * @property Location to
 *
 * @property Collection|LetterPersonAssociation[] personAssociations
 * @property Collection|LetterPrint[] prints
 * @property Collection|LetterTranscription[] transcriptions
 * @property Collection|Draft[] drafts
 * @property Collection|Facsimile[] facsimiles
 * @property Collection|LetterAttachment[] attachments
 * @property Collection|AuctionCatalogue[] auctionCatalogues
 * @property Collection|LetterInformation[] information
 * @property LetterApparatus apparatus
 * @property LetterComment comment
 */
class Letter extends Model implements IsGridable, HasMedia
{

    use SoftDeletes, HasActivity, Gridable, InteractsWithMedia;

    /**
     * Returns the field used by router
     * unique_code is the id converted to base 36 (0-Z)
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'unique_code';
    }

    /**
     * Returns full title of letter
     *
     * @return string
     */
    public function title()
    {
        $title = '#' . $this->unique_code;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transcriptions()
    {
        return $this->hasMany(LetterTranscription::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(LetterAttachment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function apparatus()
    {
        return $this->hasOne(LetterApparatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auctionCatalogues()
    {
        return $this->hasMany(AuctionCatalogue::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function comment()
    {
        return $this->hasOne(LetterComment::class);
    }

    /**
     * @return Collection
     */
    public function senders()
    {
        return $this->personAssociations->filter(function (LetterPersonAssociation $association) {
            return $association->isSender();
        })->values();
    }

    /**
     * @return Collection
     */
    public function receivers()
    {
        return $this->personAssociations->filter(function (LetterPersonAssociation $association) {
            return $association->isReceiver();
        })->values();
    }

    public function scopeByPerson(Builder $query, $personId, $type)
    {
        return $query->whereHas('personAssociations', function (Builder $query) use ($personId, $type) {
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

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(300)
            ->performOnCollections('letters.scans.handwriting_location');
    }
}
