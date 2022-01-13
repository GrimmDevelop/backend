<?php

namespace App\Http\Controllers\Data\Letters;

use App\Http\Controllers\Controller;
use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use Grimm\Transformers\LetterTransformer;
use League\Fractal\TransformerAbstract;
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
        )->parseIncludes(['senders', 'receivers', 'comment', 'prints', 'scans'])->addMeta([
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

    protected function getTransformer(): TransformerAbstract
    {
        return new LetterTransformer();
    }
}
