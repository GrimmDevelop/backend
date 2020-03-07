<?php

namespace App\Console\Commands;

use Gufy\PdfToHtml\Pdf;
use Illuminate\Console\Command;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Element;
use Smalot\PdfParser\Parser;
use Smalot\PdfParser\PDFObject;

class ParsePdfFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:parse-pdf {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Parser $parser
     * @return mixed
     * @throws \Exception
     */
    public function handle(Parser $parser)
    {
        \Gufy\PdfToHtml\Config::set('pdftohtml.bin', storage_path('bin/pdftohtml.exe'));
        \Gufy\PdfToHtml\Config::set('pdfinfo.bin', storage_path('bin/pdfinfo.exe'));
        \Gufy\PdfToHtml\Config::set('pdftohtml.output', storage_path('output/letter'));

        $pdf = new Pdf($this->argument('path'));

        $page = $pdf->html(102);

        dump($page);

        return;

        $pdf = $parser->parseFile($this->argument('path'));
        $details = $pdf->getDetails();

        foreach ($details as $property => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            echo $property . ' => ' . $value . "\n";
        }

        $pages = $pdf->getPages();

        foreach ($pages as $page) {
            collect($page->getHeader()->getElements())
                ->reject(function ($object, $type) {
                    return $object instanceof Element || $type !== 'Contents';
                })
                ->each(function (PDFObject $element) {
                    dump($element->getText());
                    dump($element->getContent());
                });
        }
    }
}
