<?php

namespace Grimm\Transformers;

use Grimm\Letter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use League\Fractal\TransformerAbstract;

class LetterTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'prints',
        'comment',
        'facsimiles',
        'senders',
        'receivers',
        'scans',
    ];

    public function transform(Letter $letter)
    {
        return [
            'id' => $letter->getRouteKey(),
            'handwriting_location' => $letter->handwriting_location,
            'date' => $letter->date,
            'from_location_derived' => $letter->from_location_derived,
            'from_location_historical' => $letter->from_location_historical,
            'code' => $letter->code,
            // 'sender_place' => $letter->from,
            // 'receiver_place' => $letter->to,
            'letter_number' => $letter->id_till_2018,
            'inc' => $letter->inc,
            'text' => $letter->text,
            'scans' => $letter->getMedia('letters.scans.handwriting_location')->map(function (Media $media) {
                return [
                    'url' => $media->getFullUrl(),
                    'thumb' => $media->getFullUrl('thumb'),
                ];
            }),
        ];
    }

    public function includePrints(Letter $letter): Collection
    {
        return $this->collection($letter->prints, new LetterPrintTransformer);
    }

    public function includeComment(Letter $letter): NullResource|Item
    {
        if ($letter->comment === null) {
            return $this->null();
        }

        return $this->item($letter->comment, new LetterCommentTransformer);
    }

    public function includeFacsimiles(Letter $letter): Collection
    {
        return $this->collection($letter->facsimiles, new LetterFacsimileTransformer);
    }

    public function includeSenders(Letter $letter): Collection
    {
        return $this->collection($letter->senders(), new LetterPersonAssociationTransformer);
    }

    public function includeReceivers(Letter $letter): Collection
    {
        return $this->collection($letter->receivers(), new LetterPersonAssociationTransformer);
    }

    public function includeScans(Letter $letter): Collection
    {
        return $this->collection(
            $letter->getMedia('letters.scans.handwriting_location'),
            new MediaTransformer(['thumb' => 'thumb'])
        );
    }
}