<?php

namespace Grimm\Grids;

use App\Grid\Column;
use App\Grid\Grid;
use Grimm\Draft;
use Grimm\Facsimile;
use Grimm\Letter;
use Grimm\LetterCode;
use Grimm\LetterPrint;

class LetterGrid extends Grid
{

    public function __construct(Letter $letter)
    {
        $codes = LetterCode::all()->map(function (LetterCode $code) use ($letter) {
            return new Column('code_' . $code->name, false, function () use ($letter, $code) {
                return $letter->information()
                    ->where('letter_code_id', $code->id)
                    ->get()
                    ->pluck('data')
                    ->implode('; ');
            });
        });

        parent::__construct('letters', collect([
            new Column('id_till_1992', false),
            new Column('id_till_1997', false),
            new Column('code', true),
            new Column('valid', false),
            new Column('date', true),
            new Column('couvert', false),
            new Column('copy_owned', false),
            new Column('language', false),
            new Column('inc', false),
            new Column('copy', false),
            new Column('attachment', false),
            new Column('directory', false),
            new Column('handwriting_location', true),
            new Column('senders', true, function () use ($letter) {
                return $letter->senders()
                    ->map(function ($association) {
                        return $association->assignment_source;
                    })
                    ->implode(' / ');
            }),
            new Column('from', false, function () use ($letter) {
                return $letter->from->historical_name ?? '[unbekannt]';
            }),
            new Column('from_id', false),
            new Column('from_source', false),
            new Column('from_date', false),
            new Column('receive_annotation', false),
            new Column('reconstructed_from', false),
            new Column('receivers', true, function () use ($letter) {
                return $letter->receivers()
                    ->map(function ($association) {
                        return $association->assignment_source;
                    })
                    ->implode(' / ');
            }),
            new Column('to', false, function () use ($letter) {
                return $letter->to->historical_name ?? '[unbekannt]';
            }),
            new Column('to_id', false),
            new Column('to_date', false),
            new Column('reply_annotation', false),
            new Column('prints', true, function () use ($letter) {
                return $letter->prints->map(function (LetterPrint $print) {
                    return $print->entry . ($print->transcription ? ' [Abschrift]' : '');
                })->implode('; ');
            }),
            new Column('drafts', false, function () use ($letter) {
                return $letter->drafts->map(function (Draft $draft) {
                    return $draft->entry;
                })->implode('; ');
            }),
            new Column('facsimiles', false, function () use ($letter) {
                return $letter->facsimiles->map(function (Facsimile $facsimile) {
                    return $facsimile->entry;
                })->implode('; ');
            }),
        ])->merge($codes)->toArray());
    }
}