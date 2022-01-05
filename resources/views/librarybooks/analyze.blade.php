@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>Grimm-Bibliothek</h1>
                <div class="button-container">
                    <div class="search {{ request()->has('cat_id') ? 'active' : '' }}">
                        <form action="{{ route('librarybooks.analyze') }}" method="get">
                            <input type="text" class="form-control form-control-sm" name="cat_id" maxlength="64"
                                   placeholder="Suche nach Buchnr." value="{{ request('cat_id') ?: '' }}"/>

                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm">
                                <span class="fa fa-search"></span>
                            </button>
                        </form>
                    </div>
                    @if(request()->has('cat_id'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-cat_id']) }}" class="btn btn-secondary btn-sm">
                                <span class="fa fa-times"></span>
                            </a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('librarybooks.create') }}" role="button" class="btn btn-secondary btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('librarybooks.store') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-12 pagination-container">
                {{ $books->appends($filter->delta())->links() }}
            </div>
            <div class="col-md-12 list-content">
                <table class="table table-hover">
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
                            onclick="location.href='{{ route('librarybooks.show', [$book]) }}'"
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
    <portal to="status-bar-left"></portal>

    <portal to="status-bar-right">
        <div style="display: flex;">
            <div class="dropup">
                @include('partials.filterSelection')
            </div>

            <a href="{{ route('librarybooks.analyze') }}" class="btn btn-primary"
               data-toggle="tooltip" title="Analyze erneut starten">
                <span class="fa fa-superpowers"></span>
            </a>
        </div>
    </portal>
@endsection

@section('scripts')
    <script src="{{ url('js/library-books.js') }}"></script>
@endsection
