<?php

namespace App\Http\Requests;

use Grimm\LetterPersonAssociation;
use Illuminate\Foundation\Http\FormRequest;

class DestroyLettersAssociationsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('letters.assign');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * @param LetterPersonAssociation $association
     */
    public function persist(LetterPersonAssociation $association)
    {
        try {
            $association->delete();
        } catch (\Exception $e) {
        }
    }
}
