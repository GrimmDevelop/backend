<?php

namespace App\Http\Requests;

use App\Rules\LetterCodeRule;
use App\Transformers\UniqueIdTransformer;
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
            'code' => ['required', new LetterCodeRule],
            'date' => 'string|required',
        ];
    }

    /**
     * Persists new letter to database
     *
     * @return Letter
     */
    public function persist()
    {
        $transformer = new UniqueIdTransformer();

        $letter = new Letter();
        // save once to set id (needed for unique_code)
        $letter->save();

        $letter->unique_code = $transformer->transform($letter->id);

        $letter->code = $this->normalizeCode($this->input('code'));

        $letter->date = $this->input('date');

        $letter->addition = $this->input('addition') ?? '';
        $letter->inc = $this->input('inc') ?? '';

        $letter->save();

        return $letter;
    }

    protected function normalizeCode($code)
    {
        return number_format(
            str_replace(',', '.', $code),
            4, '.', ''
        );
    }
}
