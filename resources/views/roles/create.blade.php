@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ route('users.index') }}#roles"><i
                                class="fa fa-caret-left"></i></a> {{ trans('users.roles.create') }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal" action="{{ route('roles.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="inputName" class="col-sm-2 col-form-label text-right">{{ trans('users.name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name"
                                   value="{{ old('name') }}" placeholder="{{ trans('users.name') }}">

                            @if ($errors->has('name'))
                                <span class="form-text">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">
                            {{ trans('users.users') }}
                        </label>
                        <div class="col-sm-10">
                            <select size="10" class="form-control" multiple name="users[]" id="users">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <h3>{{ trans('users.permissions') }}</h3>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="list-group">
                                @foreach($permissions as $permission)
                                    <div class="list-group-item">
                                        <div class="form-check">
                                            <label>
                                                <input type="checkbox" name="permissions[]"
                                                       value="{{ $permission->id }}">
                                                <strong>{{ trans($permission->name) }}</strong>
                                                <p>{{ trans('permission_desc.'.$permission->name) }}</p>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-floppy-o"></span> {{ trans('form.save') }}
                            </button>

                            <a href="{{ route('users.index') }}#roles" role="button" class="btn btn-link">
                                {{ trans('form.abort') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
