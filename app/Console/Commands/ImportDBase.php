<?php

namespace App\Console\Commands;

use App\Import\Books\Converter\BookConverter;
use App\Import\DbfProcessor;
use App\Import\Letters\Converter\LetterConverter;
use App\Import\Persons\Converter\PersonConverter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use XBase\Record;

class ImportDBase extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:import {folder} {--exclude-letters} {--exclude-persons} {--exclude-books} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import existing DBase files into database';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param DbfProcessor $processor
     * @param LetterConverter $letterConverter
     * @param PersonConverter $personConverter
     * @param BookConverter $bookConverter
     * @return mixed
     */
    public function handle(
        DbfProcessor $processor,
        LetterConverter $letterConverter,
        PersonConverter $personConverter,
        BookConverter $bookConverter
    ) {
        if (!is_readable($this->argument('folder'))) {
            $this->error('The given folder is not readable!');

            return 1;
        }

        $importPersons = !$this->option('exclude-persons');
        $importLetters = !$this->option('exclude-letters');
        $importBooks = !$this->option('exclude-books');

        $letterDbase = rtrim($this->argument('folder'), '/') . '/CORPUS.DBF';
        $personDbase = rtrim($this->argument('folder'), '/') . '/persreg.DBF';
        $bookDbase = rtrim($this->argument('folder'), '/') . '/DRUCKE.DBF';

        if (!file_exists($personDbase) && $importPersons) {
            $this->error('Person DBase File (persreg.DBF) does not exist!');

            return 1;
        }

        if (!file_exists($letterDbase) && $importLetters) {
            $this->error('Letter DBase File (CORPUS.DBF) does not exist!');

            return 1;
        }

        if (!file_exists($bookDbase) && $importBooks) {
            $this->error('Book DBase File (DRUCKE.DBF) does not exist!');

            return 1;
        }

        if ($importPersons) {
            $this->importPersons($personDbase, $processor, $personConverter);
        }

        if ($importLetters) {
            $this->importLetters($letterDbase, $processor, $letterConverter);
        }

        if ($importBooks) {
            $this->importBooks($bookDbase, $processor, $bookConverter);
        }

        return 0;
    }

    /**
     * @param $letterDbase
     * @param DbfProcessor $processor
     * @param LetterConverter $converter
     */
    protected function importLetters($letterDbase, DbfProcessor $processor, LetterConverter $converter)
    {
        if ($this->option('force')) {
            if ($this->confirm("Do you really want to delete all existing data in the letters database?")) {
                $this->clearLettersDatabase();
            }
        }

        $this->info('Import of Letters Database.');

        $this->importDatabase($letterDbase, $processor, $converter);
    }

    /**
     * @param $personDbase
     * @param DbfProcessor $processor
     * @param PersonConverter $converter
     */
    protected function importPersons($personDbase, DbfProcessor $processor, PersonConverter $converter)
    {
        if ($this->option('force')) {
            if ($this->confirm("Do you really want to delete all existing data in the person database?")) {
                $this->clearPersonDatabase();
            }
        }

        $this->info('Import of Person Database.');

        $this->importDatabase($personDbase, $processor, $converter);
    }

    /**
     * @param $bookDbase
     * @param DbfProcessor $processor
     * @param BookConverter $converter
     */
    protected function importBooks($bookDbase, DbfProcessor $processor, BookConverter $converter)
    {
        if ($this->option('force')) {
            if ($this->confirm("Do you really want to delete all existing data in the books database?")) {
                $this->clearBooksDatabase();
            }
        }

        $this->info('Import of Book Database.');
        $this->importDatabase($bookDbase, $processor, $converter);
    }

    /**
     * @param $dbFile
     * @param DbfProcessor $processor
     * @param $converter
     */
    protected function importDatabase($dbFile, DbfProcessor $processor, $converter)
    {
        $processor->open($dbFile);
        $this->info('Importing ' . $processor->getRows() . ' entries');

        $this->output->progressStart($processor->getRows());

        $converter->preflight();

        $processor->eachRow(function (Record $record, $columns) use ($converter) {
            if ($record->isDeleted()) {
                $this->output->progressAdvance();
                return;
            }

            DB::beginTransaction();
            $converter->convert($record, $columns);
            DB::commit();

            $this->output->progressAdvance();
        });

        $this->output->progressFinish();

        $this->info('Import done!');
    }

    protected function clearLettersDatabase()
    {
        DB::table('letters')->delete();
        DB::table('letter_codes')->delete();
        DB::table('locations')->delete();
        DB::statement('ALTER TABLE letters AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_codes AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_informations AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_person AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_prints AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE facsimiles AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE drafts AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE locations AUTO_INCREMENT = 1');
    }

    protected function clearPersonDatabase()
    {
        DB::raw('SET foreign_key_checks = 0;');
        DB::table('persons')->delete();
        DB::table('person_codes')->delete();
        DB::statement('ALTER TABLE persons AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE person_codes AUTO_INCREMENT = 1');
    }

    protected function clearBooksDatabase()
    {
        DB::table('books')->delete();
        DB::statement('ALTER TABLE books AUTO_INCREMENT = 1');
    }
}
