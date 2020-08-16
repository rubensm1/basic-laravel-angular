<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="/favicon.png" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/jquery.min.js"></script>
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->

    <script type="text/javascript" src="{{ asset('js/browser-detect.js') }}"></script>

    @yield('innerhead')

    <link href="{{ asset('css/style.css')  }}" rel="stylesheet"/>

    @inject('resources', 'App\Services\ResourcesService')
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" style="padding: 0px 15px;">
                    <img src="{{ asset('img/logo.png') }}" alt="EAD - UFGD" style="width: 75px;">
                </a>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(isset($resources->permissao) && ($resources->permissao != 'INATIVO'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                Processos
                            </a>
                            <ul class="dropdown-menu">
                                @if($resources->permissao == 'USUARIO' || $resources->permissao == 'ADMINISTRADOR')
                                <li>
                                    <a href="/candidato">
                                        Candidato
                                    </a>
                                </li>
                                @endif
                                @if($resources->permissao == 'ADMINISTRADOR')
                                <li>
                                    <a href="/check">
                                        Check List
                                    </a>
                                </li>
                                @endif
                                @if($resources->permissao == 'ADMINISTRADOR')
                                <li>
                                    <a href="/processos">
                                        Processos
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(isset($resources->permissao) && ($resources->permissao == 'ADMINISTRADOR'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                Administração 
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/usuarios">
                                        Usuários
                                    </a>
                                </li>
                                <li>
                                    <a href="/">
                                        Link 3
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Cadastrar</a></li>
                    @else
                        @if($resources->usuarioHackAdmin)
                            <li><a href="#" style="background-color: red; color: white;" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                Administrador Logado como: </a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" @if($resources->usuarioHackAdmin) style="color: red;" @endif class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::user()->name }} 
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div id="app">

        @yield('content')

    </div>

    <footer class="footer">
        <div class="container">
            <p>© EAD - UFGD</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('postscripts')
</body>
</html>
