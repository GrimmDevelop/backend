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
        $result = Letter::applyFilter(request('search'))->with('personAssociations')->paginate();

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
                'senders' => $letter->personAssociations->filter(fn(LetterPersonAssociation $association
                ) => $association->isSender())->pluck('assignment_source'),
                'receivers' => $letter->personAssociations->filter(fn(LetterPersonAssociation $association
                ) => $association->isReceiver())->pluck('assignment_source'),
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
