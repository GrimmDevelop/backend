<?php

namespace App\Http\Controllers\Data\Letters;

use App\Http\Controllers\Controller;
use Grimm\Letter;
use Spatie\MediaLibrary\Models\Media;

class LettersController extends Controller
{

    public function show(Letter $letter)
    {
        sleep(5);
        return fractal($letter, function (Letter $letter) {
            return [
                'id' => $letter->id,
                'handwriting_location' => $letter->handwriting_location,
                'text' => $letter->text,
                'scans' => $letter->getMedia('letters.scans.handwriting_location')->map(function (Media $media) {
                    return [
                        'url' => $media->getFullUrl(),
                        'thumb' => $media->getFullUrl('thumb')
                    ];
                })
            ];
        });
    }
}
