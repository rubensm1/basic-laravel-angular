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
    @guest
	
    @else
        @if(isset($resources->permissao) && ($resources->permissao != 'INATIVO'))
            <input type="hidden" id="permissao" name="permissao" value="{{$resources->permissao}}">
        @endif
        @if($resources->usuarioHackAdmin)
            <input type="hidden" id="usuario-hack-admin" name="usuario-hack-admin" value="{{$resources->usuarioHackAdmin}}">
        @endif
        <input type="hidden" id="usuario-logado" name="usuario-logado" value="{{Auth::user()->name}}">
    @endguest

    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('postscripts')
</body>
</html>
