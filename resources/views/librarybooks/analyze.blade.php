@extends('layouts.app')

@section('content')
    <div class="container" id="app-container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    {{-- <div class="search {{ request()->has('title') ? 'active' : '' }}">
                        <form action="{{ url('librarybooks') }}" method="get">
                            <input type="text" class="form-control input-sm" name="title" maxlength="64"
                                   placeholder="Suche" value="{{ request('title') ?: '' }}"/>

                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if(request()->has('title'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-title']) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    @endif --}}

                    <div class="search {{ request()->has('cat_id') ? 'active' : '' }}">
                        <form action="{{ route('librarybooks.analyze') }}" method="get">
                            <input type="text" class="form-control input-sm" name="cat_id" maxlength="64"
                                   placeholder="Suche nach Buchnr." value="{{ request('cat_id') ?: '' }}"/>

                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if(request()->has('cat_id'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-cat_id']) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('librarybooks.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('librarybooks.store') }}
                        </a>
                    </div>
                </div>

                <h1>
                    Grimm-Bibliothek
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('librarypeople.index') }}" role="button" class="btn-link">
                        <span class="fa fa-address-book"></span>

                        Zum Personenregister
                    </a>
                </h1>
            </div>

            <div class="col-md-12 pagination-container">
                {{ $books->appends($filter->delta())->links() }}
            </div>
            <div class="col-md-12 list-content">
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ sort_link('librarybooks/analyze', 'cat_id') }}">{{ trans('librarybooks.catalog_id_short') }} {!! sort_arrow('cat_id') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('librarybooks/analyze', 'denecke_teitge') }}">{{ trans('librarybooks.denecke_teitge') }} {!! sort_arrow('denecke_teitge') !!}</a>
                        </th>
                        <th>
                            Result
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($books->items() as $book)
                        <tr id="book-{{ $book->id }}"
                            onclick="location.href='{{ route('librarybooks.show', ['id' => $book->id]) }}'"
                            style="cursor: pointer;"
                            class="@if($book->trashed()) bg-danger @endif">
                            <td width="10%">{{ $book->catalog_id }}</td>
                            <td width="45%">{{ $book->denecke_teitge }}</td>
                            <td width="45%">
                                <ul>
                                    @foreach($analyzer->resultFor($book) as $result)
                                        <li>{{ $result }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr onclick="location.href='{{ route('librarybooks.create') }}'" style="cursor: pointer;">
                            <td class="empty-list" colspan="6">
                                In der Datenbank ist kein Buch vorhanden.
                                Möchten Sie eins erstellen?
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $books->appends($filter->delta())->links() }}
                </div>
            </div>
        </div>
    </div>
    <portal to="status-bar-left">
    </portal>

    <portal to="status-bar-right">
        <div style="display: flex;">
            @if(request()->has('cat_id'))
                <div class="btn-group">
                    <a href="{{ url()->filtered(['-cat_id']) }}" class="btn btn-danger"
                       data-toggle="tooltip" title="Denecke-Filter entfernen">
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            @endif
            @if(request()->has('denecke'))
                <div class="btn-group">
                    <a href="{{ url()->filtered(['-denecke']) }}" class="btn btn-danger"
                       data-toggle="tooltip" title="Denecke-Filter entfernen">
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            @endif
            @if(request()->has('folk'))
                <div class="btn-group">
                    <a href="{{ url()->filtered(['-folk']) }}" class="btn btn-danger"
                       data-toggle="tooltip" title="Folk-Filter entfernen">
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            @endif
            @if(request()->has('title'))
                <div class="btn-group">
                    <a href="{{ url()->filtered(['-title']) }}" class="btn btn-danger"
                       data-toggle="tooltip" title="Title-Filter entfernen">
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            @endif
            <div class="dropup">
                @include('partials.filterSelection')
            </div>

            <a href="{{ route('librarybooks.analyze') }}" class="btn btn-primary btn-sm"
               data-toggle="tooltip" title="Analyze erneut starten">
                <i class="fa fa-superpowers"></i>
            </a>
        </div>
    </portal>
@endsection

@section('scripts')
    <script src="{{ url('js/library-books.js') }}"></script>
@endsection
