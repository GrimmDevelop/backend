<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class FakeBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:fake {--status=success : Status of faked backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake last backup attempt';

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
     * @return int
     */
    public function handle()
    {
        if($this->option('status') === 'success') {
            $this->fakeSuccess();

            return Command::SUCCESS;
        }

        $this->fakeFailed();

        return Command::SUCCESS;
    }

    protected function fakeSuccess()
    {
        Redis::set('grimm.last_successful_backup', now()->toDayDateTimeString());
        Redis::set('grimm.last_backup_attempt', now()->toDayDateTimeString());
        Redis::set('grimm.last_backup_status', 'success');
        Redis::set('grimm.last_backup_name', 'Fake backup');
    }

    protected function fakeFailed()
    {
        Redis::set('grimm.last_backup_attempt', now()->toDayDateTimeString());
        Redis::set('grimm.last_backup_status', 'fail');
        Redis::set('grimm.last_backup_name', 'Fake backup');
    }
}
