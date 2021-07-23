@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>Bücherdatenbank</h1>
                <div class="button-container">
                    <div class="search {{ request()->has('title') ? 'active' : '' }}">
                        <form action="{{ url('books') }}" method="get">
                            <input type="text" class="form-control input-sm" name="title" maxlength="64"
                                   placeholder="Suche" value="{{ request()->has('title') ? request('title') : '' }}"/>
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm"><i
                                        class="fa fa-search"></i></button>

                        </form>
                    </div>
                    @if(request()->has('title'))
                        <div class="reset-search">
                            <a href="{{ url()->filtered(['-name']) }}" class="btn btn-default btn-sm"><i
                                        class="fa fa-times"></i></a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('books.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('books.store') }}
                        </a>
                    </div>
                </div>
            </div>

            @include('partials.prefixSelection', ['route' => 'books'])

            <div class="col-md-12 pagination-container">
                {{ $books->appends($filter->delta())->links() }}
            </div>
            <div class="col-md-12 list-content">
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th><a href="{{ sort_link('books', 'id') }}"># {!! sort_arrow('id') !!}</a></th>
                        <th>
                            <a href="{{ sort_link('books', 'short_title') }}">{{ trans('books.short_title') }}  {!! sort_arrow('short_title') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('books', 'title') }}">{{ trans('books.title') }}  {!! sort_arrow('title') !!}</a>
                        </th>
                        {{-- <th><a href="{{ sort_link('books', 'year') }}">Jahr  {!! sort_arrow('year') !!}</a></th>--}}
                        <th>
                            <a href="{{ sort_link('books', 'volume') }}">{{ trans('books.volume') }}  {!! sort_arrow('volume') !!}</a>
                        </th>
                        <th><a href="{{ sort_link('books', 'edition') }}">Edition {!! sort_arrow('edition') !!}</a></th>
                        <th><a href="{{ sort_link('books', 'source') }}">Herkunft {!! sort_arrow('source') !!}</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books->items() as $book)
                        <tr id="book-{{ $book->id }}"
                            onclick="location.href='{{ route('books.show', ['id' => $book->id]) }}'"
                            style="cursor: pointer;" class="@if($book->trashed()) bg-danger @endif">
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->short_title }}</td>
                            <td>{{ $book->title }}</td>
                            {{-- <td>{{ $book->year }}</td> --}}
                            <td>
                                {{ $book->volume }}
                                @if($book->volume_irregular)
                                    <span data-toggle="tooltip" data-title="Zusatzband">({{ $book->volume_irregular }})
                                        )</span>
                                @endif
                            </td>
                            <td>{{ $book->edition }}</td>
                            <td>{{ $book->source }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                {{ $books->appends($filter->delta())->links() }}
            </div>
        </div>
    </div>

    <portal to="status-bar-left">
    </portal>

    <portal to="status-bar-right">
        <div style="display: flex;">
            @include('partials.filterSelection')
        </div>
    </portal>
@endsection
@section('scripts')
    <script src="{{ url('js/library-books.js') }}"></script>
@endsection

