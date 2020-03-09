<nav class="navbar navbar-light navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggler collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Grimmbriefwechsel - Verwaltung
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav">
                @can('letters.*')
                    <li class="nav-item {{ active_if(request()->is('letters*')) }}">
                        <a class="nav-link" href="{{ route('letters.index') }}">{{ trans('letters.letters') }}</a>
                    </li>
                @endcan
                @can('people.*')
                    <li class="nav-item {{ active_if(request()->is('people*')) }}">
                        <a class="nav-link" href="{{ route('people.index') }}">{{ trans('people.people') }}</a>
                    </li>
                @endcan
                @can('books.*')
                    <li class="nav-item {{ active_if(request()->is('books*')) }}">
                        <a class="nav-link" href="{{ route('books.index') }}">{{ trans('books.books') }}</a>
                    </li>
                @endcan
                @can('library.*')
                    <li class="nav-item dropdown {{ active_if(request()->is('library*')) }}">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ trans('librarybooks.library') }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="nav-item {{ active_if(request()->is('librarybooks')) }}">
                                <a class="nav-link text-nowrap"
                                   href="{{ route('librarybooks.index') }}">
                                    <span class="fa fa-btn fa-university"></span>
                                    {{ trans('librarybooks.library') }}
                                </a>
                            </li>
                            <li class="nav-item {{ active_if(request()->is('librarypeople')) }}">
                                <a class="nav-link text-nowrap"
                                   href="{{ route('librarypeople.index') }}">
                                    <span class="fa fa-btn fa-address-book"></span>
                                    Personenregister
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('admin.*')
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ trans('admin.admin') }}
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @can('users.*')
                                <li class="nav-item {{ active_if(request()->is('users*')) }}">
                                    <a class="nav-link text-nowrap"
                                       href="{{ route('users.index') }}">
                                        <span class="fa fa-btn fa-users"></span>
                                        {{ trans('users.users') }}
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                            @endcan
                            @can('admin.deployment')
                                <li class="nav-item">
                                    <a class="nav-link text-nowrap"
                                       href="{{ route('admin.deployment.index') }}">
                                        <span class="fa fa-btn fa-globe"></span>
                                        {{ trans('admin.deployment') }}
                                    </a>
                                </li>
                            @endcan
                            @can('admin.import')
                                <li class="nav-item">
                                    <a class="nav-link text-nowrap"
                                       href="{{ route('admin.import.index') }}">
                                        <span class="fa fa-btn fa-cloud-upload"></span>
                                        {{ trans('admin.import') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    @include('partials.backup-link')
                </li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-item"><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ auth()->user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('users.show', [auth()->user()->id]) }}">
                                    <span class="fa fa-btn fa-user"></span> Profil
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/logout') }}">
                                    <span class="fa fa-btn fa-sign-out"></span> Logout</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
