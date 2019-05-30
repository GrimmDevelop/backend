<?php

namespace Grimm\Grids;

use App\Grid\Column;
use App\Grid\Grid;
use Grimm\AuctionCatalogue;
use Grimm\Draft;
use Grimm\Facsimile;
use Grimm\Letter;
use Grimm\LetterAttachment;
use Grimm\LetterCode;
use Grimm\LetterPrint;
use Grimm\LetterTranscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

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
            }, function (Builder $query, $search) use ($code) {
                $query->whereHas('information', function (Builder $q) use ($code, $search) {
                    $q->join('letter_codes', function (JoinClause $join) use ($code) {
                        $join->on('letter_codes.id', '=', 'letter_informations.letter_code_id')
                            ->where('letter_codes.name', $code->name);
                    })->where('data', 'LIKE', "%$search%");
                });
            });
        });

        parent::__construct('letters', collect([
            new Column('unique_code', true),
            new Column('id_till_2018', false),
            new Column('id_till_1992', false),
            new Column('id_till_1997', false),
            new Column('code', true),
            new Column('date', true),
            new Column('couvert', false),
            new Column('language', false),
            new Column('inc', false),
            new Column('copy', false),
            new Column('directory', false),
            new Column('handwriting_location', false),
            new Column('senders', true, function () use ($letter) {
                return $letter->senders()
                    ->map(function ($association) {
                        return $association->assignment_source;
                    })
                    ->implode(' / ');
            }, function (Builder $query, $search) {
                $query->whereHas('personAssociations', function (Builder $q) use ($search) {
                    $q->where('type', 0)
                        ->where('assignment_source', 'LIKE', "%$search%");
                });
            }),
            new Column('from_location_historical', false, function () use ($letter) {
                return $letter->from_location_historical ?? '[nicht angegeben]';
            }),
            new Column('from_location_derived', false, function () use ($letter) {
                return $letter->from_location_derived ?? '[nicht erschlossen]';
            }),
            new Column('from_date', false),
            new Column('receive_annotation', false),
            new Column('reconstructed_from', false),
            new Column('receivers', true, function () use ($letter) {
                return $letter->receivers()
                    ->map(function ($association) {
                        return $association->assignment_source;
                    })
                    ->implode(' / ');
            }, function (Builder $query, $search) {
                $query->whereHas('personAssociations', function (Builder $q) use ($search) {
                    $q->where('type', 1)
                        ->where('assignment_source', 'LIKE', "%$search%");
                });
            }),
            new Column('to_location_historical', false, function () use ($letter) {
                return $letter->to_location_historical ?? '[nicht angegeben]';
            }),
            new Column('to_date', false),
            new Column('reply_annotation', false),
            new Column('prints', false, function () use ($letter) {
                return $letter->prints->map(function (LetterPrint $print) {
                    return $print->entry;
                })->implode('; ');
            }, 'prints.entry'),
            new Column('transcriptions', false, function () use ($letter) {
                return $letter->transcriptions->map(function (LetterTranscription $print) {
                    return $print->entry;
                })->implode('; ');
            }, 'transcriptions.entry'),
            new Column('attachments', false, function () use ($letter) {
                return $letter->attachments->map(function (LetterAttachment $print) {
                    return $print->entry;
                })->implode('; ');
            }, 'attachments.entry'),
            new Column('drafts', false, function () use ($letter) {
                return $letter->drafts->map(function (Draft $draft) {
                    return $draft->entry;
                })->implode('; ');
            }),
            new Column('facsimiles', false, function () use ($letter) {
                return $letter->facsimiles->map(function (Facsimile $facsimile) {
                    return $facsimile->entry;
                })->implode('; ');
            }, 'facsimiles.entry'),
            new Column('auctionCatalogues', false, function () use ($letter) {
                return $letter->auctionCatalogues->map(function (AuctionCatalogue $catalogue) {
                    return $catalogue->entry;
                })->implode('; ');
            }, 'auctionCatalogues.entry'),
            new Column('addition', true),
        ])->merge($codes)->toArray());
    }
}