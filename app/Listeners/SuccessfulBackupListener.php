<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Redis;
use Spatie\Backup\Events\BackupWasSuccessful;

class SuccessfulBackupListener
{

    /**
     * Handle the event.
     *
     * @param  BackupWasSuccessful $event
     */
    public function handle(BackupWasSuccessful $event)
    {
        Redis::set('grimm.last_successful_backup', now()->toDayDateTimeString());
        Redis::set('grimm.last_backup_attempt', now()->toDayDateTimeString());
        Redis::set('grimm.last_backup_status', 'success');
        Redis::set('grimm.last_backup_name', $event->backupDestination->backupName());
    }
}
