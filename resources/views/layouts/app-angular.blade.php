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

	<base href="/">
	<link id="themeStyleSheet" rel="stylesheet" type="text/css" href="css/themes/nova-dark/theme.css" />

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

	<div class="container" style="width: 100%; max-width: 100%; padding: 0px;">
		@if(isset($param))
			<input type="hidden" id="uid" name="uid" value="{{$param}}">
		@endif
		<app-root><i style="text-align: center; display: block">Carregando...</i></app-root>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
		</form>
	</div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/angular/runtime.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/angular/polyfills.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/angular/styles.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/angular/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/angular/main.js') }}"></script>
</body>
</html>


