<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-transparent p-0 pt-3">
            <div class="container-fluid">
                <div class="col-2">
                    @yield('left-nav')
                    <p class="navbar-brand-mine text-uppercase fs-2 d-block w-100 text-center"
                        href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </p>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div>
            @if (session()->has('success'))
                <div class="alert alert-success w-50 mx-auto my-3">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger w-50 mx-auto my-3">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
        <main class="container-fluid">
            @yield('content')
        </main>
        <footer>
            <div class="text-center py-3">
                <h5>Copyright &copy; Voca by <a class="text-decoration-none" href="tel: 0096340090043">AMD</a> </h5>
            </div>
        </footer>
    </div>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/fontawesome/js/all.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/jQuery-3.6.0/jquery-3.6.0.min.js') }}"></script> --}}
    <script src="{{ asset('vendor/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js') }}"></script>
    @yield('script')
</body>

</html>
