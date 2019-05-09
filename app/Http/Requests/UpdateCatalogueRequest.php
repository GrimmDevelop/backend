<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;
use Grimm\AuctionCatalogue;

class UpdateCatalogueRequest extends Request
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

    public function persist(AuctionCatalogue $catalogue)
    {
        $catalogue->entry = $this->input('entry');
        $catalogue->year = $this->input('year');
        $catalogue->save();

        return $catalogue;
    }
}
