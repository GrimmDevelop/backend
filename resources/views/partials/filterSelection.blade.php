@if(!$filter->selectable()->isEmpty())
    <div class="btn-group">
        <a href="{{ toggle_active_filters($filter) }}" class="btn btn-secondary" data-toggle="tooltip"
           title="{{ ($filter->hasSelected()) ? trans('filters.remove') : trans('filters.about') }}"
           data-container="body">Filter <span
                class="badge badge-warning {{ ($filter->hasSelected()) ? '': 'd-none' }}">{{ $filter->selected()->count() }}</span></a>
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            @foreach($filter->selectable() as $f)
                <a class="dropdown-item {{ active_if($f->applied())  }}"
                    href="{{ url()->filtered([$f->appliesTo()]) }}">{{ trans($f->displayString()) }}</a>
            @endforeach
        </ul>
    </div>
@endif
@if($filter->hasFilter('trash'))
    <div class="btn-group">
        <a href="{{ url()->filtered(['trash']) }}" type="button"
           class="btn btn-{{ $filter->filterFor('trash')->value() == 1 ? 'warning' : ($filter->filterFor('trash')->value() == 2 ? 'danger' : 'secondary') }}"
           data-toggle="tooltip" title="{{ $filter->filterFor('trash')->nextTitle() }}">
            <span class="fa fa-trash-o"></span>
        </a>
    </div>
@endif
