<a href="#" class="nav-link backup-link" data-container="body" data-toggle="popover" data-placement="bottom"
   data-title="Datensicherung"
   data-content="{{ $backup->popoverText() }}">
    <span class="badge badge-{{ $backup->statusLabel() }}">
        <span class="fa fa-cloud"></span>
    </span>
</a>
