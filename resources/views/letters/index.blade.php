@extends('layouts.app')

@section('content')
    <div class="container" id="letters">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ request()->has('search') ? 'active' : '' }}">
                        <form action="{{ url('letters') }}" method="get">
                            <input type="text" class="form-control input-sm" name="search" maxlength="64"
                                   placeholder="Suche" value="{{ request('search') ?: '' }}"/>
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm"><i
                                        class="fa fa-search"></i></button>

                        </form>
                    </div>
                    @if(request()->has('search'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-search']) }}" class="btn btn-default btn-sm"><i
                                        class="fa fa-times"></i></a>
                        </div>
                    @endif

                    <div class="generic">
                        <a href="{{ route('letters.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('letters.store') }}
                        </a>
                    </div>
                </div>
                <h1>Briefdatenbank</h1>
            </div>

            <div class="col-md-12 pagination-container">
                {{ $letters->appends($filter->delta())->links() }}
            </div>
            <div class="col-md-12 list-content">
                <div class="add-button">
                </div>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        {{--<th>
                            <a href="{{ sort_link('letters', 'id') }}"># {!! sort_arrow('id') !!}</a>
                        </th>--}}
                        @foreach(\Grimm\Letter::gridColumns() as $column)
                            <th>
                                <a href="{{ sort_link('letters', $column->name()) }}">
                                    {{ trans('letters.' . $column->name()) }}
                                    {!! sort_arrow($column->name()) !!}
                                </a>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($letters->items() as $index => $letter)
                        <tr id="letter-{{ $letter->id }}"
                            onclick="location.href='{{ route('letters.show', [$letter]) }}'"
                            style="cursor: pointer;"
                            class="@if($letter->trashed()) bg-danger @endif">
                            @foreach($letter->grid()->columns() as $column)
                                <td>
                                    {{ $letter->gridify($column) }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr onclick="location.href='{{ route('letters.create') }}'" style="cursor: pointer;">
                            <td class="empty-list" colspan="6">In der Datenbank ist kein Brief vorhanden. Möchten Sie
                                einen erstellen?
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $letters->appends($filter->delta())->links() }}
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
                    <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Spalten <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu" style="width: 600px;">
                        @foreach(\Grimm\Letter::gridColumns(true, true) as $column)
                            <li {!! active_if($column->isActive()) !!} style="float: left; width: 31.33%; margin: 0 1%;">
                                <a href="{{ url()->filtered_grid(route('letters.index'), [$column->name() => (int) !$column->isActive()]) }}">
                                    {{ trans('letters.' . $column->name()) }}
                                </a>
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

            @include('partials.filterSelection')

            <div class="btn-group">
                <form action="{{ route('letters.export') . '?' . http_build_query($filter->delta()) }}"
                      method="post"
                      style="display: inline;"
                      @submit="showLimitWarning({{ $exportLimitExceeded }})">
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
    <script>
        window.LETTERS = [];
    </script>
    <script src="{{ url('js/letters.js') }}"></script>
    <script>
        $(function () {
            // Prevent submission of search form if search input is empty
            $('#search-btn').on('click', function (ev) {
                if ($('input[name="search"]').val() == '') {
                    ev.preventDefault();
                }
            });
        })
    </script>
@endsection
