@extends('layouts.app')

@section('content')
    <div class="container" id="app-container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ request()->has('name') ? 'active' : '' }}">
                        <form action="{{ url('people') }}" method="get">
                            <input type="text" class="form-control input-sm" name="name" maxlength="64"
                                   placeholder="Suche" value="{{ request('name') ?: '' }}"/>
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm"><i
                                        class="fa fa-search"></i></button>

                        </form>
                    </div>
                    @if(request()->has('name'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-name']) }}" class="btn btn-default btn-sm"><i
                                        class="fa fa-times"></i></a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('people.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('people.store') }}
                        </a>
                    </div>
                </div>
                <h1>Personendatenbank</h1>
            </div>
            <div class="col-md-12 pagination-container">
                {{ $people->appends($filter->delta())->links() }}
            </div>
            @include('partials.prefixSelection', ['route' => 'people'])

            <div class="col-md-12 list-content">
                <div class="add-button">
                </div>
                <table class="table table-responsive table-hover">
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
                            <td class="empty-list" colspan="6">In der Datenbank ist keine Person vorhanden. Möchten Sie
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
    <portal to="status-bar-left">

        @include('partials.prefixSelection', ['route' => 'library'])

    </portal>

    <portal to="status-bar-right">
        <div style="display: flex;">
            <div class="dropup">
                @include('partials.pageSizeSelection')
            </div>

            @if(request()->has('correspondence'))
                <div class="btn-group">
                    <a href="{{ url()->filtered(['-correspondence']) }}" class="btn btn-danger"
                       data-toggle="tooltip" title="Correspondence-Filter entfernen">
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            @endif

            <div class="dropup">
                <div class="btn-group">
                    <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Spalten <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach(\Grimm\Person::gridColumns(true) as $column)
                            <li {!! active_if($column->isActive()) !!}>
                                <a href="{{ route('people.index') }}?grid={{ $column->name() }}&state={{ (int) !$column->isActive() }}">{{ $column->name() }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if(request()->has('correspondence'))
                <div class="btn-group">
                    <a href="{{ url()->filtered(['-correspondence']) }}" class="btn btn-danger"
                       data-toggle="tooltip" title="Correspondence-Filter entfernen">
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            @endif

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
                        <i class="fa fa-download"></i>
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
                if ($('input[name="name"]').val() == '') {
                    ev.preventDefault();
                }
            });
        })
    </script>
@endsection
