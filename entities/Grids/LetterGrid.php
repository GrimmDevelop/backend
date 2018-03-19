<?php

namespace Grimm\Grids;

use App\Grid\Column;
use App\Grid\Grid;
use Grimm\Letter;
use Grimm\LetterPrint;

class LetterGrid extends Grid
{

    public function __construct(Letter $letter)
    {
        parent::__construct('letters', [
            new Column('id_till_1992', false),
            new Column('id_till_1997', false),
            new Column('code', false),
            new Column('valid', false),
            new Column('date', true),
            new Column('couvert', true),
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
            new Column('prints', true, function() use($letter) {
                return $letter->prints->map(function(LetterPrint $print) {
                    return $print->entry . ($print->transcription ? ' [Abschrift]' : '');
                })->implode('; ');
            }),
        ]);
    }
}