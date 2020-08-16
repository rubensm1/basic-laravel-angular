@extends('layouts.app')

@inject('resources', 'App\Services\ResourcesService')

@section('content')
<div class="content">
    <div class="title m-b-md">
        {{ config('app.name') }}
    </div>

    <div class="links">
        @guest
            <a href="/login/">Login</a>
            <a href="/register/">Cadastro</a>
        @else
            @if(isset($resources->permissao) && ($resources->permissao == 'USUARIO' || $resources->permissao == 'ADMINISTRADOR'))
                <a href="/eu">Usuário</a>
            @endif
            @if(isset($resources->permissao) && ($resources->permissao == 'ADMINISTRADOR'))
                <a href="/">Link 2</a>
            @endif
            @if(isset($resources->permissao) && ($resources->permissao == 'ADMINISTRADOR'))
                <a href="/usuarios/">Lista de Usuários</a>
            @endif
        @endguest
        
    </div>
</div>
@endsection
