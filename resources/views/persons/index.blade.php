@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="search {{ Request::has('name') ? 'active' : '' }}">
                        <form action="{{ url('persons') }}" method="get">
                            <input type="text" class="form-control input-sm" name="name" maxlength="64" placeholder="Suche" value="{{ Request::has('name') ? Request::get('name') : '' }}" />
                            <button id="search-btn" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>

                        </form>
                    </div>
                    @if(Request::has('name'))
                        <div class="reset-search">
                            <a href="{{ url('persons') }}" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                        </div>
                    @endif
                    <div class="generic">
                        <a href="{{ route('persons.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('people.store') }}
                        </a>
                    </div>
                </div>
                <h1>Personendatenbank</h1>
            </div>
            <div class="col-md-12 pagination-container">
                {{ $persons->appends(Request::except('page'))->links() }}
            </div>
            <div class="col-md-12 list-content">
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        {{--<th><a href="{{ sort_link('persons', 'id') }}"># {!! sort_arrow('id') !!}</a></th>--}}
                        <th><a href="{{ sort_link('persons', 'last_name') }}">Nachname {!! sort_arrow('last_name') !!}</a></th>
                        <th><a href="{{ sort_link('persons', 'first_name') }}">Vorname {!! sort_arrow('first_name') !!}</a></th>
                        <th><a href="{{ sort_link('persons', 'is_organization') }}"><i class="fa fa-user"></i> / <i class="fa fa-building"></i> {!! sort_arrow('is_organization') !!}</a></th>
                        <th><a href="{{ sort_link('persons', 'source') }}">Quelle {!! sort_arrow('source') !!}</a></th>
                        <th><a href="{{ sort_link('persons', 'bio_data') }}">Biogr. Daten {!! sort_arrow('bio_data') !!}</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($persons->items() as $person)
                        <tr onclick="location.href='{{ route('persons.show', ['id' => $person->id]) }}'" style="cursor: pointer;" class="@if($person->auto_generated) bg-warning @endif">
                            {{--<td>{{ $person->id }}</td>--}}
                            <td>{{ $person->last_name }}</td>
                            <td>{{ $person->first_name }}</td>
                            <td>@if(!$person->is_organization)
                                    <i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Mensch"></i>
                                    @else
                                    <i class="fa fa-building" data-toggle="tooltip" data-placement="top" title="Organisation (Uni o.ä.)"></i>
                            @endif</td>
                            <td>{{ $person->source }}</td>
                            <td>{{ $person->bio_data }}</td>
                        </tr>
                    @empty
                        <tr onclick="location.href='{{ route('persons.create') }}'" style="cursor: pointer;">
                            <td class="empty-list" colspan="6">In der Datenbank ist keine Person vorhanden. Möchten Sie eine erstellen?</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 pagination-container">
                <div class="pagination-container">
                    {{ $persons->appends(Request::except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Prevent submission of search form if search input is empty
            $('#search-btn').on('click', function(ev) {
                if ($('input[name="name"]').val() == '') {
                    ev.preventDefault();
                }
            });
        })
    </script>
@endsection