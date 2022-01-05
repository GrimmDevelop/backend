<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup grimm keys required to run grimm application';

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
        $this->call('key:generate', ['--force' => true]);
        $this->call('passport:keys', ['--force' => true]);

        return 0;
    }
}
