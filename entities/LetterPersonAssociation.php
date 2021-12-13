<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LetterPersonAssociation
 * @package Grimm
 *
 * @property int id
 * @property int letter_id
 * @property int person_id
 * @property string assignment_source
 * @property int type
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 *
 * @property Letter letter
 * @property Person person
 */
class LetterPersonAssociation extends Model
{
    const SENDER = 0;
    const RECEIVER = 1;
    const MENTION = 2;

    protected $table = 'letter_person';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function isSender()
    {
        return $this->type === static::SENDER;
    }

    public function isReceiver()
    {
        return $this->type === static::RECEIVER;
    }

    public function isMention()
    {
        return $this->type === static::MENTION;
    }

    public function makePersonSender()
    {
        $this->type = static::SENDER;
    }

    public function makePersonReceiver()
    {
        $this->type = static::RECEIVER;
    }

    public function makePersonMentioned()
    {
        $this->type = static::MENTION;
    }

    public function scopeSearch(Builder $builder, $term)
    {
        $builder
            ->where('assignment_source', 'like', '%' . $term . '%')
            ->groupBy('assignment_source');
    }
}
