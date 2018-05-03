<?php

namespace App\Http\Requests;

use Grimm\Letter;
use Illuminate\Foundation\Http\FormRequest;

class StoreLetterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('letters.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'string|required',
            'date' => 'nullable|string',
        ];
    }

    /**
     * Persists new letter to database
     *
     * @return Letter
     */
    public function persist()
    {
        $letter = new Letter();

        $letter->code = $this->input('code');
        $letter->date = $this->input('date');

        $letter->addition = $this->input('addition');
        $letter->inc = $this->input('inc');

        $letter->save();

        return $letter;
    }
}
