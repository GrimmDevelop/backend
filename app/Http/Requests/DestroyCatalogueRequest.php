<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Gate;
use Grimm\AuctionCatalogue;

class DestroyCatalogueRequest extends Request
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
            //
        ];
    }

    public function persist(AuctionCatalogue $catalogue)
    {
        try {
            $catalogue->delete();
        } catch (\Exception $e) {
        }
    }
}
