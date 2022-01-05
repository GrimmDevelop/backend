@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>{{ trans('users.store') }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal" action="{{ route('users.store') }}" method="post">
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

                    <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="inputEmail" class="col-sm-2 col-form-label text-right">{{ trans('users.email') }}</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" name="email"
                                   value="{{ old('email') }}" placeholder="{{ trans('users.email') }}">

                            @if ($errors->has('email'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="inputPassword" class="col-sm-2 col-form-label text-right">{{ trans('users.password') }}</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                   value="{{ old('password') }}" placeholder="{{ trans('users.password') }}">

                            @if ($errors->has('password'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="inputPasswordConfirm"
                               class="col-sm-2 col-form-label text-right">{{ trans('users.password_confirmation') }}</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPasswordConfirm"
                                   name="password_confirmation"
                                   value="{{ old('password_confirmation') }}"
                                   placeholder="{{ trans('users.password_confirmation') }}">

                            @if ($errors->has('password_confirmation'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('api_only') ? ' has-error' : '' }}">
                        <label class="col-sm-2 col-form-label text-right">{{ trans('users.api_only') }}</label>
                        <div class="col-sm-10">
                            <label class="form-check-inline">
                                <input type="radio" name="api_only" id="api_only1"
                                       value="0" {{ checked(old('api_only', 0), 0) }}>
                                Nein
                            </label>
                            <label class="form-check-inline">
                                <input type="radio" name="api_only" id="api_only2"
                                       value="1" {{ checked(old('api_only', 0), 1) }}>
                                Ja
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">
                            {{ trans('users.roles.name') }}
                        </label>
                        <div class="col-sm-10">
                            <select size="5" class="form-control" multiple name="roles[]" id="roles">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-floppy-o"></span> {{ trans('form.save') }}
                            </button>

                            <a href="{{ route('users.index') }}" role="button" class="btn btn-link">
                                {{ trans('form.abort') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
