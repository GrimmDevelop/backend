<?php

namespace App\Import;

use App\Events\ImportDone;
use App\Events\ImportProgress;
use App\Import\Books\Converter\BookConverter;
use App\Import\Letters\Converter\LetterConverter;
use App\Import\Persons\Converter\PersonConverter;
use App\Import\Preimport\DatabaseClearer;
use DB;
use Grimm\User;
use XBase\Record;

class ModelImporter
{

    private $chunkLimit = 50;
    private $total;
    private $progress;
    private $initiator;
    private $force = false;

    /**
     * @var DbfProcessor
     */
    private $processor;
    /**
     * @var LetterConverter
     */
    private $lettersConverter;
    /**
     * @var PersonConverter
     */
    private $peopleConverter;
    /**
     * @var BookConverter
     */
    private $booksConverter;
    /**
     * @var ImportService
     */
    private $import;
    /**
     * @var DatabaseClearer
     */
    private $clearer;

    /**
     * ModelImporter constructor.
     * @param ImportService $import
     * @param DbfProcessor $processor
     * @param LetterConverter $lettersConverter
     * @param PersonConverter $peopleConverter
     * @param BookConverter $booksConverter
     * @param DatabaseClearer $clearer
     */
    public function __construct(
        ImportService $import,
        DbfProcessor $processor,
        LetterConverter $lettersConverter,
        PersonConverter $peopleConverter,
        BookConverter $booksConverter,
        DatabaseClearer $clearer
    ) {
        $this->import = $import;
        $this->processor = $processor;
        $this->lettersConverter = $lettersConverter;
        $this->peopleConverter = $peopleConverter;
        $this->booksConverter = $booksConverter;
        $this->clearer = $clearer;
    }

    public function initiator(User $initiator)
    {
        $this->initiator = $initiator;

        return $this;
    }

    public function force()
    {
        $this->force = true;

        return $this;
    }

    public function import()
    {
        $totalLetters = 0;
        $totalPeople = 0;
        $totalBooks = 0;

        foreach ($this->import->databases() as $database) {
            if ($this->force) {
                $method = 'clear' . ucfirst($database['type']) . 'Database';

                $this->clearer->{$method}();
            }

            $variable = 'total' . ucfirst($database['type']);

            ${$variable} = $this->importDatabase(
                $database['path'],
                $this->processor,
                $this->{$database['type'] . 'Converter'},
                function ($progress, $total) use ($database) {
                    event(new ImportProgress($progress, $total, $database['type'], $this->initiator));
                }
            );
        }

        event(
            new ImportDone(
                $totalLetters,
                $totalPeople,
                $totalBooks,
                $this->initiator
            )
        );

        $this->import->setInProgress(false);
    }

    /**
     * @param $dbFile
     * @param DbfProcessor $processor
     * @param $converter
     * @param callable $progressCallback
     * @return int
     */
    protected function importDatabase(
        $dbFile,
        DbfProcessor $processor,
        ModelConverter $converter,
        callable $progressCallback
    ) {
        $processor->open($dbFile);

        $totalRows = $processor->getRows();

        $this->progressStart($totalRows);

        $converter->preflight();

        $processor->eachRow(function (Record $record, $columns) use ($converter, $progressCallback) {
            if ($record->isDeleted()) {
                $this->progressAdvance($progressCallback);
                return;
            }

            DB::beginTransaction();
            try {
                $converter->convert($record, $columns);
            } catch (\Exception $e) {

            }
            DB::commit();

            $this->progressAdvance($progressCallback);
        });

        return $totalRows;
    }

    private function chunkFinished()
    {
        return $this->isChunkLimit() || $this->isTotalLimit();
    }

    private function isChunkLimit()
    {
        return $this->progress % $this->chunkLimit == 0;
    }

    private function isTotalLimit()
    {
        return $this->progress == $this->total;
    }

    private function progressStart($total)
    {
        $this->progress = 0;
        $this->total = $total;
    }

    private function progressAdvance(callable $progressCallback)
    {
        $this->progress++;

        if ($this->chunkFinished()) {
            call_user_func($progressCallback, $this->progress, $this->total);
        }
    }
}