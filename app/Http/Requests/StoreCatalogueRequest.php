<?php

namespace App\Http\Requests;

use Gate;
use Grimm\AuctionCatalogue;
use Grimm\Letter;

class StoreCatalogueRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('letters.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entry' => 'required|string',
        ];
    }

    public function persist(Letter $letter)
    {
        $catalogue = new AuctionCatalogue();
        $catalogue->entry = $this->input('entry');
        $catalogue->year = $this->input('year');
        $catalogue->letter()->associate($letter);
        $catalogue->save();

        return $catalogue;
    }
}
