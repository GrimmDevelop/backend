<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Grimmbriefwechsel - Verwaltung
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @can('letters.*')
                    <li {!! active_if(request()->is('letters*')) !!}>
                        <a href="{{ route('letters.index') }}">{{ trans('letters.letters') }}</a>
                    </li>
                @endcan
                @can('people.*')
                    <li {!! active_if(request()->is('people*')) !!}>
                        <a href="{{ route('people.index') }}">{{ trans('people.people') }}</a>
                    </li>
                @endcan
                @can('books.*')
                    <li {!! active_if(request()->is('books*')) !!}>
                        <a href="{{ route('books.index') }}">{{ trans('books.books') }}</a>
                    </li>
                @endcan
                @can('library.*')
                    <li {!! active_if(request()->is('library*')) !!}>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ trans('librarybooks.library') }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {!! active_if(request()->is('librarybooks')) !!}>
                                <a href="{{ route('librarybooks.index') }}"
                                   style="display: flex; align-items: center;">
                                    <div style="width: 3rem;">
                                        <span class="fa fa-university fa-2x"></span>
                                    </div>
                                    <span style="flex: 1; padding: 1rem 0.7rem;">
                                        {{ trans('librarybooks.library') }}
                                    </span>
                                </a>
                            </li>
                            <li {!! active_if(request()->is('librarypeople')) !!}>
                                <a href="{{ route('librarypeople.index') }}"
                                   style="display: flex; align-items: center;">
                                    <div style="width: 3rem;">
                                        <span class="fa fa-address-book fa-2x"></span>
                                    </div>
                                    <span style="flex: 1; padding: 1rem 0.7rem;">
                                        Personenregister
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('admin.*')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('admin.admin') }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @can('users.*')
                                <li {!! active_if(request()->is('users*')) !!}>
                                    <a href="{{ route('users.index') }}"
                                       style="display: flex; align-items: center;">
                                        <div style="width: 3rem;">
                                            <span class="fa fa-users fa-2x"></span>
                                        </div>
                                        <span style="flex: 1; padding: 1rem 0.7rem;">
                                            {{ trans('users.users') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                            @endcan
                            @can('admin.deployment')
                                <li>
                                    <a href="{{ route('admin.deployment.index') }}"
                                       style="display: flex; align-items: center;">
                                        <div style="width: 3rem;">
                                            <span class="fa fa-globe fa-2x"></span>
                                        </div>
                                        <span style="flex: 1; padding: 1rem 0.7rem;">
                                            {{ trans('admin.deployment') }}
                                        </span>
                                    </a>
                                </li>
                            @endcan
                            @can('admin.import')
                                <li>
                                    <a href="{{ route('admin.import.index') }}"
                                       style="display: flex; align-items: center;">
                                        <div style="width: 3rem;">
                                            <span class="fa fa-cloud-upload fa-2x"></span>
                                        </div>
                                        <span style="flex: 1; padding: 1rem 0.7rem;">
                                            {{ trans('admin.import') }}
                                        </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    @include('partials.backup-link')
                </li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ auth()->user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('users.show', [auth()->user()->id]) }}"><i
                                            class="fa fa-btn fa-user"></i> Profil</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>