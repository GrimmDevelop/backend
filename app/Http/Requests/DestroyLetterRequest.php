<?php

namespace App\Http\Requests;

use Grimm\Letter;
use Illuminate\Foundation\Http\FormRequest;

class DestroyLetterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('letters.delete');
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
     * @param Letter $letter
     */
    public function persist(Letter $letter)
    {
        try {
            $letter->delete();
        } catch (\Exception $e) {
        }
    }
}
