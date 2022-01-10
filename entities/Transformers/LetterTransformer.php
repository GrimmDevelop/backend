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
    ];

    /*Alles in den Transformer

    Für Alles (alle Relationships) auch einen Tranformer
    Mit return new Transformer

    print -> entry, year, is transkription als bool casten $letter->prints()->orderBy('sort')->get(),

    Man kann immer im model gucken was es für properties hat.

    mit include relationship für scans auch umbauen, sodass es nicht gemapped wird, sondern mit relation
    auch für senders und receivers
    links:
    - https://laravel.com/docs/8.x/eloquent-relationships#one-to-many-inverse (relations)
    - https://laravel.com/docs/master/queries#where-clauses

    */

    public function transform(Letter $letter)
    {
        return [
            'id' => $letter->getRouteKey(),
            'handwriting_location' => $letter->handwriting_location,
            'date' => $letter->date,
            'from_location_derived' => $letter->from_location_derived,
            'from_location_historical' => $letter->from_location_historical,
//            'prints' => $letter->prints, /*correct?*/ /*printed_in?*/
//            'comments' => $letter->comment, /*comments?*/
            'code' => $letter->code, /*correct?*/
            'sender_place' => $letter->from,
            'receiver_place' => $letter->to,
            'letter_number' => $letter->id_till_2018,
//            'facsimiles' => $letter->facsimiles,
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
    }

    /**
     * Include Prints
     *
     * @param Letter $letter
     * @return Collection
     */
    public function includePrints(Letter $letter)
    {
        $prints = $letter->prints;

        return $this-> Collection($prints, new LetterPrintTransformer());
    }

    /**
     * Include Comment
     *
     * @param Letter $letter
     * @return Item
     */
    public function includeComments(Letter $letter)
    {
        $comment = $letter -> comment;

        return $this -> Item($comment, new LetterCommentTransformer());
    }

    /**
     * @param Letter $letter
     * @return Collection
     */
    public function includeFacsimiles(Letter $letter)
    {
        $facsimile = $letter->facsimiles;

        return $this -> Collection($facsimile, new LetterFacsimileTransformer);
    }


}