<?php

namespace Grimm;

use App\Grid\Grid;
use App\Grid\Gridable;
use App\Grid\IsGridable;
use Carbon\Carbon;
use Grimm\Grids\PersonGrid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer id
 * @property string ddb_id
 * @property string last_name
 * @property string first_name
 * @property string full_name
 * @property string full_first_name
 * @property string birth_date
 * @property string death_date
 * @property string bio_data
 * @property string bio_data_source
 * @property string add_bio_data
 * @property boolean is_organization
 * @property boolean auto_generated
 * @property string source
 *
 * @property Collection|PersonInformation[] information
 * @property Collection|PersonPrint[] prints
 * @property Collection|PersonInheritance[] inheritances
 * @property Collection|BookPersonAssociation[] bookAssociations
 * @property Collection|PersonReference[] references
 *
 * @property Carbon created_at
 */
class Person extends Model implements IsGridable
{
    use SoftDeletes, CollectPrefixes, HasActivity, Gridable;

    public static $unknownName = 'unknown';

    protected $table = 'persons';

    protected $fillable = [
        'id',
        'ddb_id',
        'last_name',
        'first_name',
        'full_name',
        'full_first_name',
        'birth_date',
        'death_date',
        'bio_data',
        'bio_data_source',
        'add_bio_data',
        'is_organization',
        'auto_generated',
        'source',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $prefixable = [
        'last_name',
    ];

    /**
     * Returns the full name of person and/or organization
     *
     * @param bool $full
     * @return string
     */
    public function normalizeName(bool $full = false): string
    {
        $lastName = $full ? $this->full_name : $this->last_name;
        $firstName = $full ? $this->full_first_name : $this->first_name;

        if(!$lastName && !$firstName) {
            return static::$unknownName;
        }

        if ($this->is_organization || !$firstName) {
            return $lastName;
        }

        if(!$lastName) {
            return $firstName;
        }

        return $lastName . ', ' . $firstName;
    }

    /**
     * @return bool
     */
    public function hasCorrespondence()
    {
        return $this->letterAssociations()->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function information()
    {
        return $this->hasMany(PersonInformation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prints()
    {
        return $this->hasMany(PersonPrint::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inheritances()
    {
        return $this->hasMany(PersonInheritance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookAssociations()
    {
        return $this->hasMany(BookPersonAssociation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function references()
    {
        return $this->hasMany(PersonReference::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function letterAssociations()
    {
        return $this->hasMany(LetterPersonAssociation::class);
    }

    /**
     * Search for a person by name
     *
     * @param  Builder $query The query object
     * @param  string $name The name searched for
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByName(Builder $query, $name)
    {
        return $query->whereRaw('match(full_first_name, full_name, first_name, last_name) against (? in boolean mode)', [$name]);
    }

    public function scopeFullInfo(Builder $query)
    {
        return $query->with([
            'information' => function ($query) {
                $query->whereHas('code', function ($q) {
                    $q->where('internal', false);
                });
            },
            'information.code' => function ($query) {
                $query->where('person_codes.internal', false);
            },
            'prints',
            'inheritances',
            'bookAssociations',
        ]);
    }

    public function scopeDetails(Builder $query)
    {
        return $query->with([
            'information.code' => function ($query) {
                $query->orderBy('person_codes.name');
            },
            'prints' => function ($query) {
                $query->orderBy('year', 'asc');
            },
            'inheritances',
            'references',
            'bookAssociations.book' => function ($query) {
                $query->orderBy('books.title');
            },
            'activities' => function ($query) {
                $query->latest()->with('user');
            },
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::restored(function (Person $model) {
            $model->bookAssociations()->whereHas('book', function ($q) {
                $q->whereNull('deleted_at');
            })->restore();
        });

        static::deleted(function (Person $model) {
            $model->bookAssociations()->delete();
        });
    }

    public function grid(): Grid
    {
        return new PersonGrid($this);
    }
}
