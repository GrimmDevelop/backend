@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>Personendatenbank</h1>
                <div class="button-container">
                    <div class="search {{ request()->has('search') ? 'active' : '' }}">
                        <form action="{{ url('people') }}" method="get">
                            <select class="form-control input-sm" name="field">
                                <option value="" {{ selected_if(!request()->get('field')) }}>alle Felder</option>
                                @foreach(\Grimm\Person::gridColumns() as $column)
                                    <option value="{{ $column->name() }}" {{ selected_if(request()->get('field') === $column->name()) }}>
                                        {{ trans('people.' . $column->name()) }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control input-sm" name="search" maxlength="64"
                                   placeholder="Suche" value="{{ request('search') ?: '' }}"/>
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if(request()->has('search'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-search']) }}" class="btn btn-default btn-sm"><i
                                        class="fa fa-times"></i></a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('people.create') }}" role="button" class="btn btn-secondary btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('people.store') }}
                        </a>
                    </div>
                </div>
            </div>
            @include('partials.prefixSelection', ['route' => 'people'])
            <div class="col-md-12 pagination-container">
                {{ $people->appends($filter->delta())->links() }}
            </div>

            <div class="col-md-12 list-content">
                <div class="add-button">
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ sort_link('people', 'id') }}"># {!! sort_arrow('id') !!}</a>
                            </th>
                            @foreach(\Grimm\Person::gridColumns() as $column)
                                <th>
                                    <a href="{{ sort_link('people', $column->name()) }}">
                                        {{ trans('people.' . $column->name()) }}
                                        {!! sort_arrow($column->name()) !!}
                                    </a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($people->items() as $index => $person)
                            <tr id="person-{{ $person->id }}"
                                onclick="location.href='{{ route('people.show', ['id' => $person->id]) }}'"
                                style="cursor: pointer;"
                                class="@if($person->auto_generated) bg-warning @endif @if($person->trashed()) bg-danger @endif">
                                <td>{{ $person->id }}</td>
                                @foreach($person->grid()->columns() as $column)
                                    <td>
                                        {{ $person->gridify($column) }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr onclick="location.href='{{ route('people.create') }}'" style="cursor: pointer;">
                                <td class="empty-list" colspan="6">In der Datenbank ist keine Person vorhanden. Möchten
                                    Sie
                                    eine erstellen?
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $people->appends($filter->delta())->links() }}
                </div>
            </div>
        </div>
    </div>
    <portal to="status-bar-left"></portal>

    <portal to="status-bar-right">
        <div style="display: flex;">
            <div class="dropup">
                @include('partials.pageSizeSelection')
            </div>
            <div class="dropup">
                <div class="btn-group">
                    <a href="#" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle">Spalten <span
                                class="caret"></span></a>
                    <div class="dropdown-menu dropdown-menu-right" style="width: 600px;">
                        @foreach(\Grimm\Person::gridColumns(true) as $column)
                            <a class="dropdown-item {{ active_if($column->isActive()) }}"
                               style="float: left; width: calc(33.33% - 1rem); margin: 0 0.5rem; clear:none;"
                               href="{{ route('people.index') }}?grid={{ $column->name() }}&state={{ (int) !$column->isActive() }}">
                                {{ trans('people.' . $column->name()) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="dropup">
                @include('partials.filterSelection')
            </div>

            <div class="btn-group">
                <form action="{{ route('people.export') . '?' . http_build_query($filter->delta()) }}"
                      method="post"
                      style="display: inline;">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-info"
                            data-toggle="tooltip" title="Daten exportieren">
                        <span class="fa fa-download"></span>
                    </button>
                </form>
            </div>
        </div>
    </portal>
@endsection

@section('scripts')
    <script src="{{ url('js/library-people.js') }}"></script>
    <script>
        $(function () {
            // Prevent submission of search form if search input is empty
            $('#search-btn').on('click', function (ev) {
                if ($('input[name="name"]').val() === '') {
                    ev.preventDefault();
                }
            });
        })
    </script>
@endsection
