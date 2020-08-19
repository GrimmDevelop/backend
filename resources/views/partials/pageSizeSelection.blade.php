<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle">p. Seite <span
            class="caret"></span></a>
    <ul class="dropdown-menu">
        @foreach($filter->filterFor('page-size')->pageSizes() as $pageSize)
            <a class="dropdown-item {{ active($filter->filterFor('page-size')->pageSize(), $pageSize) }}"
               href="{{ url()->filtered(['page-size' => $pageSize]) }}">{{ $pageSize }}
            </a>
        @endforeach
    </ul>
</div>
