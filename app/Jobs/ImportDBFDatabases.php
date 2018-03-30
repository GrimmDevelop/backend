<?php

namespace App\Jobs;

use App\Events\ImportProgress;
use App\Import\Books\Converter\BookConverter;
use App\Import\DbfProcessor;
use App\Import\ImportService;
use App\Import\Letters\Converter\LetterConverter;
use App\Import\ModelImporter;
use App\Import\Persons\Converter\PersonConverter;
use Grimm\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportDBFDatabases implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->onQueue('import-queue');
    }

    /**
     * Execute the job.
     *
     * @param ModelImporter $importer
     * @return void
     */
    public function handle(
        ModelImporter $importer
    ) {
        $importer->initiator($this->user)
            ->force()
            ->import();
    }
}
