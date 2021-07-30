<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Redis;
use Spatie\Backup\Events\BackupHasFailed;

class FailedBackupListener
{

    /**
     * Handle the event.
     *
     * @param  BackupHasFailed $event
     */
    public function handle(BackupHasFailed $event)
    {
        Redis::set('grimm.last_backup_attempt', now()->toDayDateTimeString());
        Redis::set('grimm.last_backup_status', 'fail');
        Redis::set('grimm.last_backup_name', $event->backupDestination->backupName());
    }
}
