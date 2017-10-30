<?php

namespace Grimm;

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
        return $this->type === 0;
    }

    public function isReceiver()
    {
        return $this->type === 1;
    }

    public function isMention()
    {
        return $this->type === 2;
    }

    public function makePersonSender()
    {
        $this->type = 0;
    }

    public function makePersonReceiver()
    {
        $this->type = 1;
    }

    public function makePersonMentioned()
    {
        $this->type = 2;
    }
}
