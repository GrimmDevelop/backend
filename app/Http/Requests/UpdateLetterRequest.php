<?php

namespace App\Http\Requests;

use Grimm\Letter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLetterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('letters.update');
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
            'valid' => 'nullable|boolean',
        ];
    }

    public function persist(Letter $letter)
    {
        $letter->code = number_format($this->input('code'), 4, '.', '');
        $letter->date = $this->input("date") ?? '';
        $letter->valid = $this->input("valid");
        $letter->addition = $this->input("addition") ?? '';
        $letter->inc = $this->input("inc") ?? '';
        $letter->couvert = $this->input("couvert");
        $letter->copy_owned = $this->input("copy_owned");
        $letter->language = $this->input("language");
        $letter->copy = $this->input("copy");
        $letter->attachment = $this->input("attachment");
        $letter->directory = $this->input("directory");
        $letter->handwriting_location = $this->input("handwriting_location");
        $letter->from_source = $this->input("from_source");
        $letter->from_date = $this->input("from_date");
        $letter->receive_annotation = $this->input("receive_annotation");
        $letter->reconstructed_from = $this->input("reconstructed_from");
        $letter->to_date = $this->input("to_date");
        $letter->reply_annotation = $this->input("reply_annotation");

        $letter->save();
    }
}
