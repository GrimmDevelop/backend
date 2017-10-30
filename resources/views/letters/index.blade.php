@extends('layouts.app')

@section('content')
    <div class="container">
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
            </div>
            <div class="col-md-12 list-content">
                <div class="add-button">
                    @include('partials.filterSelection')
                </div>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ sort_link('letters', 'id') }}"># {!! sort_arrow('id') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('letters', 'code') }}">{{ trans('letters.code') }} {!! sort_arrow('code') !!}</a>
                        </th>
                        <th>
                            <a href="{{ sort_link('letters', 'date') }}">{{ trans('letters.date') }} {!! sort_arrow('date') !!}</a>
                        </th>
                        <th>
                            {{ trans('letters.senders') }}
                        </th>
                        <th>
                            {{ trans('letters.from') }}
                        </th>
                        <th>
                            {{ trans('letters.receivers') }}
                        </th>
                        <th>
                            {{ trans('letters.to') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($letters->items() as $letter)
                        <tr id="person-{{ $letter->id }}"
                            onclick="location.href='{{ route('letters.show', ['id' => $letter->id]) }}'"
                            style="cursor: pointer;"
                            class="@if($letter->trashed()) bg-danger @endif">
                            <td>{{ $letter->id }}</td>
                            <td>{{ $letter->code }}</td>
                            <td>{{ $letter->date }}</td>
                            <td>{{ $letter->senders()->pluck('assignment_source')->implode(' / ') }}</td>
                            <td>{{ $letter->from->historical_name ?? '[unbekannt]' }}</td>
                            <td>{{ $letter->receivers()->pluck('assignment_source')->implode(' / ') }}</td>
                            <td>{{ $letter->to->historical_name ?? '[unbekannt]' }}</td>
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
