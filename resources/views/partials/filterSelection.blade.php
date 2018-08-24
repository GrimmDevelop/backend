@if(!$filter->selectable()->isEmpty())
    <div class="btn-group">
        <a href="{{ toggle_active_filters($filter) }}" class="btn btn-default" data-toggle="tooltip"
           title="{{ ($filter->hasSelected()) ? trans('filters.remove') : trans('filters.about') }}"
           data-container="body">Filter <span
                    class="badge {{ ($filter->hasSelected()) ? '': 'hide' }}">{{ $filter->selected()->count() }}</span></a>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            @foreach($filter->selectable() as $f)
                <li {!! active_if($f->applied())  !!} ><a
                            href="{{ url()->filtered([$f->appliesTo()]) }}">{{ trans($f->displayString()) }}</a></li>
            @endforeach
        </ul>
    </div>
@endif
@if($filter->hasFilter('trash'))
    <div class="btn-group">

        <a href="{{ url()->filtered(['trash']) }}" type="button"
           class="btn btn-{{ ($filter->filterFor('trash')->applied()) ? 'danger' : 'default' }}"
           data-toggle="tooltip" title="Gelöschte Elemente anzeigen">
            <i class="fa fa-trash-o"></i>
        </a>
    </div>
@endif
