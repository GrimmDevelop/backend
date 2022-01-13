<?php


namespace App\Backup;


use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class BackupStatusReader
{

    protected const GRACE_PERIOD = 3;

    public function lastBackupAttempt($format = null)
    {
        $data = Redis::get('grimm.last_backup_attempt');

        if ($data == '') {
            return '';
        }

        $date = Carbon::createFromTimeString($data);

        return $format !== null ? $date->format($format) : $date;
    }

    public function lastBackupStatus()
    {
        return Redis::get('grimm.last_backup_status');
    }

    public function lastSuccessfulBackup($format = null)
    {
        $data = Redis::get('grimm.last_successful_backup');

        if ($data == '') {
            return '';
        }

        $date = Carbon::createFromTimeString($data);

        return $format !== null ? $date->format($format) : $date;
    }

    public function statusLabel()
    {
        if ($this->lastBackupIsOld()) {
            return 'warning';
        }

        if ($this->lastBackupStatus() == 'success') {
            return 'success';
        }

        return ($this->lastBackupStatus() == 'fail') ? 'danger' : 'secondary';
    }

    public function lastBackupName()
    {
        return Redis::get('grimm.last_backup_name');
    }

    /**
     * @return bool
     */
    protected function lastBackupIsOld()
    {
        return Carbon::now()->diffInDays($this->lastSuccessfulBackup()) > static::GRACE_PERIOD;
    }

    public function popoverText()
    {
        if(!$this->hasBackup()) {
            return 'Es wurde noch keine Sicherung gestartet.';
        }

        return "Name: {$this->lastBackupName()}<br>Letzter Sicherungsversuch: {$this->lastBackupAttempt('d.m.Y H:i')}<br>Letzte erfolgreiche Sicherung: {$this->lastSuccessfulBackup('d.m.Y H:i')}";
    }

    private function hasBackup():bool
    {
        return Redis::get('grimm.last_backup_status') != '';
    }
}
