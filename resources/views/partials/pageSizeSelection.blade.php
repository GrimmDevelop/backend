<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">p. Seite <span
                class="caret"></span></a>
    <ul class="dropdown-menu">
        @foreach($filter->filterFor('page-size')->pageSizes() as $pageSize)
            <li {!! active($filter->filterFor('page-size')->pageSize(), $pageSize) !!}>
                <a href="{{ url()->filtered(['page-size' => $pageSize]) }}">{{ $pageSize }}</a>
            </li>
        @endforeach
    </ul>
</div>