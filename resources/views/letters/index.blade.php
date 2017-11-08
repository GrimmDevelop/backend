@extends('layouts.app')

@section('content')
    <div class="container" id="letters">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ request()->has('name') ? 'active' : '' }}">
                        <form action="{{ url('letters') }}" method="get">
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

                @include('partials.pageSizeSelection')

                <div class="btn-group">
                    <a href="#" data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle">Spalten <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach(\Grimm\Letter::staticGridColumns(true) as $column)
                            <li {!! active_if($column->isActive()) !!}>
                                <a href="{{ route('letters.index') }}?grid={{ $column->name() }}&state={{ (int) !$column->isActive() }}">{{ $column->name() }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @include('partials.filterSelection')
            </div>
            <div class="col-md-12 list-content">
                <div class="add-button">
                </div>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ sort_link('letters', 'id') }}"># {!! sort_arrow('id') !!}</a>
                        </th>
                        @foreach(\Grimm\Letter::staticGridColumns() as $column)
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
                            onclick="location.href='{{ route('letters.show', ['id' => $letter->id]) }}'"
                            style="cursor: pointer;"
                            class="@if($letter->trashed()) bg-danger @endif">
                            <td>{{ $letter->id }}</td>
                            @foreach($letter->gridColumns() as $column)
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
@endsection

@section('scripts')
    <script>
        window.LETTERS = {!! $letters->toJson() !!};
    </script>
    <script src="{{ url('js/letters.js') }}"></script>
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
