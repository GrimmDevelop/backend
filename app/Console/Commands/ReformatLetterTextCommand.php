<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class ReformatLetterTextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:format-letter-text {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reformat HTML code of given text';

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
     * @return mixed
     */
    public function handle(Filesystem $filesystem)
    {
       $path = $this->argument('path');

       if($filesystem->isDirectory($path)) {
           foreach($filesystem->allFiles($path) as $file) {
               $this->info($file);
               $this->format($file->getContents());
           }
       }

       if(!file_exists($path)) {
           throw new FileNotFoundException();
       }

       $this->format(file_get_contents($path));

    }

    protected function format($html)
    {
        $html = preg_replace('<p class="top_nav">(.*?)<br\/><\/p>', '', $html);
        //remove top overhang

        $html = preg_replace('<p class="s9"(.*?)<\/body><\/html>', '<\/body><\/html>', $html);
        //remove stuff after the letter

        $html = str_replace('<span class="p">', '<span class="p" style="padding-left: 15pt; text-indent: 0; text-align: justify;">', $html);
        //correct left padding

        $html = str_replace('<p style="text-indent: 0pt;text-align: left;"><br/></p><p style="text-indent: 0pt;text-align: left;"><br/></p>', '', $html);
        //remove page brakes

        $html = str_replace('<p style=\"padding-top: 4pt;padding-left: 307pt;text-indent: 0pt;text-align: right;\">', '<p style=\"padding-top: 4pt;text-indent: 0pt;text-align: right;\">', $html);
        //remove left padding for the date

        $html = str_replace('<p style="padding-left: 351pt;text-indent: 0pt;text-align: left;">', '<p style="padding-left: 15pt;text-indent: 0pt;text-align: right;">', $html);
        //straighten signature

        dump($html);
    }
}
