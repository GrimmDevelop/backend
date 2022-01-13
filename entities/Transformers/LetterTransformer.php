<?php

namespace Grimm\Transformers;

use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
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
        'comments',
        'facsimiles',
        'senders',
        'receivers',
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
            'senders' => $letter->personAssociations->filter(fn(LetterPersonAssociation $association) => $association->isSender())->pluck('name'),
            'receivers' => $letter->personAssociations->filter(fn(LetterPersonAssociation $association) => $association->isReceiver())->pluck('name'),
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

    /**
     * Include Prints
     *
     * @param Letter $letter
     * @return Collection
     */
    public function includePrints(Letter $letter)
    {
        return $this->collection($letter->prints, new LetterPrintTransformer);
    }

    /**
     * Include Comment
     *
     * @param Letter $letter
     * @return Item
     */
    public function includeComments(Letter $letter)
    {
        return $this->item($letter->comment, new LetterCommentTransformer);
    }

    /**
     * @param Letter $letter
     * @return Collection
     */
    public function includeFacsimiles(Letter $letter)
    {
        return $this->collection($letter->facsimiles, new LetterFacsimileTransformer);
    }

    public function includeSenders(Letter $letter)
    {
        return $this->collection($letter->senders(), new LetterPersonAssociationTransformer);
    }

    public function includeReceivers(Letter $letter)
    {
        return $this->collection($letter->receivers(), new LetterPersonAssociationTransformer);
    }
}