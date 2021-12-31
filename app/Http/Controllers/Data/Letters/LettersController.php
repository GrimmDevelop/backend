<?php

namespace App\Http\Controllers\Data\Letters;

use App\Http\Controllers\Controller;
use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LettersController extends Controller
{
    public function index()
    {
        if (request('mode') === 'advanced') {
            $result = Letter::applyFilter(request('search'))
                ->with('personAssociations')
                ->paginate(request('limit'));
        } else {
            $result = Letter::search(request('searchAll'), null, true)
                ->with('personAssociations')
                ->paginate(request('limit'));
        }

        return fractal()->collection(
            $result->items(),
            $this->getTransformer()
        )->addMeta([
            'total' => $result->total(),
            'current' => $result->currentPage(),
            'per_page' => $result->perPage(),
            'last_page' => $result->lastPage(),
        ]);
    }

    public function show(Letter $letter)
    {
        return fractal($letter, $this->getTransformer());
    }

    protected function getTransformer(): callable
    {
        return function (Letter $letter) {
            return [
                'id' => $letter->getRouteKey(),
                'handwriting_location' => $letter->handwriting_location,
                'date' => $letter->date,
                'from_location_derived' => $letter->from_location_derived,
                'from_location_historical' => $letter->from_location_historical,
                'prints' => $letter->prints, /*correct?*/ /*printed_in?*/
                'comments' => $letter->comment, /*comments?*/
                'code' => $letter->code, /*correct?*/
                'sender_place' => $letter->from,
                'receiver_place' => $letter->to,
                'letter_number' => $letter->id, /*id or unique_code or id_till_* or code ?*/
                'facsimiles' => $letter->facsimiles,
                'senders' => $letter->personAssociations->filter(fn(LetterPersonAssociation $association
                ) => $association->isSender())->pluck('name'),
                'receivers' => $letter->personAssociations->filter(fn(LetterPersonAssociation $association
                ) => $association->isReceiver())->pluck('name'),
                'inc' => $letter->inc,
                'text' => $letter->text,
                'scans' => $letter->getMedia('letters.scans.handwriting_location')->map(function (Media $media) {
                    return [
                        'url' => $media->getFullUrl(),
                        'thumb' => $media->getFullUrl('thumb'),
                    ];
                }),
            ];
        };
    }
}
