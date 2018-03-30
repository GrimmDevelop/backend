<?php

namespace App\Deployment\Transformers;

use App\Deployment\MappingProvider;
use League\Fractal\TransformerAbstract;

class LibraryBookTransformer extends TransformerAbstract implements MappingProvider
{

    /**
     * Transforms a single library book into a new form
     *
     * @param \Grimm\LibraryBook $item
     *
     * @return mixed
     */
    public function transform($item)
    {
        return [
            'id' => $item->id,
            'catalog_id' => $item->catalog_id,
            'title' => $item->title,
            'denecke_teitge' => $item->denecke_teitge,
            'volumes' => $item->volumes,
            'vols_year' => $item->vols_year,
            'numbers' => $item->numbers,
            'place' => $item->place,
            'publisher' => $item->publisher,
            'year' => $item->year,
            'pages' => $item->pages,
            'handwritten_dedication' => $item->handwritten_dedication,
            'notes_jg' => $item->notes_jg,
            'notes_wg' => $item->notes_wg,
            'notes_other' => $item->notes_other,
            'particularities' => $item->particularities,
            'place_of_storage' => $item->place_of_storage,
            'purchase_number' => $item->purchase_number,
            'shelf_mark' => $item->shelf_mark,
            'tales_comm_1856' => $item->tales_comm_1856,
            'external_digitization' => $item->external_digitization,
            'series_title' => $item->series_title,
        ];
    }

    public function mappings()
    {
        return [
            'book' => [
                'properties' => [
                    'id' => [
                        'type' => 'long',
                    ],
                    'catalog_id' => [
                        'type' => 'string',
                    ],
                    'title' => [
                        'type' => 'string',
                    ],
                    'denecke_teitge' => [
                        'type' => 'string',
                    ],
                    'volumes' => [
                        'type' => 'string',
                    ],
                    'vols_year' => [
                        'type' => 'long',
                    ],
                    'numbers' => [
                        'type' => 'long',
                    ],
                    'place' => [
                        'type' => 'string',
                    ],
                    'publisher' => [
                        'type' => 'string',
                    ],
                    'year' => [
                        'type' => 'string',
                    ],
                    'pages' => [
                        'type' => 'string',
                    ],
                    'handwritten_dedication' => [
                        'type' => 'string',
                    ],
                    'notes_jg' => [
                        'type' => 'string',
                    ],
                    'notes_wg' => [
                        'type' => 'string',
                    ],
                    'notes_other' => [
                        'type' => 'string',
                    ],
                    'particularities' => [
                        'type' => 'string',
                    ],
                    'place_of_storage' => [
                        'type' => 'string',
                    ],
                    'purchase_number' => [
                        'type' => 'string',
                    ],
                    'shelf_mark' => [
                        'type' => 'string',
                    ],
                    'tales_comm_1856' => [
                        'type' => 'string',
                    ],
                    'external_digitization' => [
                        'type' => 'string',
                    ],
                    'series_title' => [
                        'type' => 'string',
                    ],
                ],
            ],
        ];
    }
}