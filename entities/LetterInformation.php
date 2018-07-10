<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string data
 * @property int letter_code_id
 *
 * @property LetterCode code
 * @property Letter letter
 */
class LetterInformation extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function code()
    {
        return $this->belongsTo(LetterCode::class, 'letter_code_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
