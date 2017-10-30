<?php

namespace App\Providers;

use App\Import\Books\Converter\BookConverter;
use App\Import\Books\Parser\GrimmParser;
use App\Import\Books\Parser\SourceParser;
use App\Import\Books\Parser\TitleParser;
use App\Import\Books\Parser\YearParser;
use App\Import\Letters\Converter\LetterConverter;
use App\Import\Letters\Parser\AuktkatParser;
use App\Import\Letters\Parser\CodeParser;
use App\Import\Letters\Parser\DraftParser;
use App\Import\Letters\Parser\FacsimileParser;
use App\Import\Letters\Parser\FromToParser;
use App\Import\Letters\Parser\IdParser;
use App\Import\Letters\Parser\MultiDataParser;
use App\Import\Letters\Parser\PrintParser;
use App\Import\Letters\Parser\RestFieldParser;
use App\Import\Letters\Parser\SenderReceiverParser;
use App\Import\Persons\BioDataExtractor;
use App\Import\Persons\Converter\PersonConverter;
use App\Import\Persons\Parser\BioDataParser;
use App\Import\Persons\Parser\InheritanceParser;
use App\Import\Persons\Parser\NameParser;
use App\Import\Persons\Parser\PersonPrintParser;
use App\Import\Persons\Parser\RestFieldParser as PersonRestFieldParser;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->app->singleton(LetterConverter::class, function () {
            $converter = new LetterConverter();

            $converter->registerParsers([
                new AuktkatParser(),
                new CodeParser(),
                new DraftParser(),
                new FacsimileParser(),
                new IdParser(),
                new MultiDataParser(),
                new PrintParser(),
                new SenderReceiverParser(),
                new FromToParser(),
                new RestFieldParser()
            ]);

            return $converter;
        });

        $this->app->singleton(PersonConverter::class, function () {
            $converter = new PersonConverter();

            $converter->registerParsers([
                new NameParser(),
                new BioDataParser(app(BioDataExtractor::class)),
                new PersonPrintParser(),
                new InheritanceParser(),
                new PersonRestFieldParser(),
            ]);

            return $converter;
        });

        $this->app->singleton(BookConverter::class, function () {
            $converter = new BookConverter();

            $converter->registerParsers([
                new TitleParser(),
                new YearParser(),
                new SourceParser(),
                new GrimmParser(),
            ]);

            return $converter;
        });
    }
}
