<?php

namespace App\Http\Controllers;

use App\Inscricao;
use App\Operacao;
use App\Processo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('authdev:admin');
        //$this->middleware('auth');
       /* $this->middleware('check.papel:'.Processo::PAPEL_AVALIADOR_PRESIDENTE, 
            ['only' => ['testarOperacao']]);*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("layouts.app-angular");
    }


    public function loginTeste() {
        Auth::attempt(['login'=> 'user', 'password' =>'pass']);
        return view('home');
    }


    public function testeAngular(){
        return view("layouts.app-angular");
    }
}
