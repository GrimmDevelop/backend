<?php

namespace Grimm\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaTransformer extends TransformerAbstract
{

    protected array $withConversions;

    public function __construct(array $withConversions = [])
    {
        $this->withConversions = $withConversions;
    }

    public function transform(Media $media): array
    {
        $data = [
            'url' => $media->getFullUrl(),
        ];

        foreach ($this->withConversions as $key => $conversion) {
            $data[$key] = $media->getFullUrl($conversion);
        }

        return $data;
    }
}