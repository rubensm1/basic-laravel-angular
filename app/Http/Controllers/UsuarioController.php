<?php

namespace App\Http\Controllers;

use App\Processo;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Validator;
use Illuminate\Support\Facades\Session;
use App\User;
use Exception;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissao:'.User::PERMISSAO_ADMINISTRADOR, ['except' => ['usuario','candidato', 'update', 'atualizar']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$u = Usuario::with(['setor:id,sigla,campus_id'])->get(['id','login','nome','email','permissao','setor_id']);
        //$u = Usuario::all();
        //return $u;
        //return view('config.usuarios',['usuarios' => $this->all()]);
        return view("layouts.app-angular");
    }
    public function candidato()
    {
        return view("layouts.app-angular");
    }
    
    public function check () {
        return view("layouts.app-angular");
    }

    public function admCandidato(Request $request)
    {
        if ($request->input( 'id') && $this->usuarioLogado()->permissao != User::PERMISSAO_ADMINISTRADOR)
            abort(401, "Usuário não Autorizado!");
        return view("layouts.app-angular", ['param' => $request->input( 'id')]);
    }
    public function all()
    {
        return User::all();
    }
    public function simplificada()
    {
        $us =  User::select('id', 'name', 'login')
            ->where('id', '>', 1)
            ->orderBy('name')
            ->get();

        $simp = [];
        foreach ($us as $u) {
            $simp[] = (object) ['id' => $u->id, 'name' => $u->name, 'login' => $u->login];
        }
        return $simp;
    }

    public function usuario ($id = NULL) {
        $logado = $this->usuarioLogado();
        if ($id && $logado->id != $id) {
            if ($logado->permissao == User::PERMISSAO_ADMINISTRADOR)
                return User::find($id);
            abort (401, "Usuário não Autorizado!");
        }
        return $logado;
    }

    public function usuarioLogado() {
        return Auth::user();
    }

    public function isAdministrador() {
        return $this->usuarioLogado()->permissao == User::PERMISSAO_ADMINISTRADOR;
    }

    public function logarComo(Request $request, $uid)
    {
        $user = User::find($uid);
        if ($user!= null) {
            $this->setUsuarioAdminHackId($request, $this->usuarioLogado()->id);
            Auth::login(Auth::loginUsingId($user->id));
            if (Auth::user() != NULL)
                return redirect('/');
        }
        abort(401, "Usuário '$uid' não identificado!");
    }
    private function setUsuarioAdminHackId(Request $request, $id) {
        $request->session()->put('usuarioAdminHackId', $id);
        return $id;
    }
    public function getUsuarioAdminHackId(Request $request = NULL) {
        if ($request) {
            if ($request->session()->has('usuarioAdminHackId'))
                return $request->session()->get('usuarioAdminHackId');
        }
        else {
            if (Session::has('usuarioAdminHackId'))
                return Session::get('usuarioAdminHackId');
        }
        return 0;
    }
    public function resetUsuarioAdminHackId(Request $request) {
        if ($request->session()->has('usuarioAdminHackId'))
            $request->session()->forget('usuarioAdminHackId');
        return 1;
    }

    private function getValidationRules($full = false) {
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'nome'        => 'required',
            'email'       => 'required|email',
            'permissao'   => 'required|permissao',
            //'nerd_level' => 'required|numeric'
        );
        if ($full)
            $rules['login'] = 'required|numeric';
        return $rules;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(400, "teste '" . $request->input('name')."'");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {

        $us = User::findOrFail($usuario);

        return $us;
    }

    public function atualizar(Request $request, User $usuario)
    {
        //abort(400, "teste '" . $usuario->login."'");
        return $this->update($request, $usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        //$us = Usuario::findOrFail($usuario);
        //return $usuario->with(['setor:id,sigla,campus_id'])->get(['id','login','nome','email','permissao','setor_id']);
        return $usuario;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $logado = $this->usuarioLogado();
        if ($logado->permissao == User::PERMISSAO_ADMINISTRADOR) {
            $usuario->name = $request->input('name');
            $usuario->email = $request->input('email');
        }
        else if ($logado->id != $usuario->id) {
            abort(401, "Usuário sem Permissão para esta ação");
        }

        //$usuario->permissao = $request->input('permissao');
        try{
            $usuario->save();
        }
        catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        return $usuario;
    }

    public function updatePermissao(Request $request, $usuarioId) {

        $usuario = User::findOrFail($usuarioId);
        if ($usuario) {
            $usuario->permissao = $request->input( 'permissao');
            $usuario->save();

            return $usuario;
        }
        else 
            abort(400, "Usuário não encontrado");
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        if ($usuario->delete()) {
            return new User();
        }
        else {
            abort(404, 'Usuário não encontrado');
        }
    }
}
