<a href="#" class="nav-link backup-link" data-container="body" data-toggle="popover" data-placement="bottom"
   data-title="Datensicherung"
   data-content="Name: {{ $backup->lastBackupName() }}<br>Letzter Sicherungsversuch: {{ $backup->lastBackupAttempt('d.m.Y H:i') }}<br>Letzte erfolgreiche Sicherung: {{ $backup->lastSuccessfulBackup('d.m.Y H:i') }}">
    <span class="badge badge-{{ $backup->statusLabel() }}">
        <span class="fa fa-cloud"></span>
    </span>
</a>
