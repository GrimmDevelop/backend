<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle">p. Seite <span
                class="caret"></span></a>
    <ul class="dropdown-menu">
        @foreach($filter->filterFor('page-size')->pageSizes() as $pageSize)
            <li><a href="{{ url()->filtered(['page-size' => $pageSize]) }}">{{ $pageSize }}</a></li>
        @endforeach
    </ul>
</div>