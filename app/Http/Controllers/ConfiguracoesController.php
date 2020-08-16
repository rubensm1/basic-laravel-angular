<?php

namespace App\Http\Controllers;

use App\Configuracoes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ConfiguracoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissao:'.User::PERMISSAO_ADMINISTRADOR);
    }

    public function index()
    {
        return view("layouts.app-angular");
    }

    public function config() {
        $emailSuporte = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_EMAIL_SUPORTE)->first();
        $prefixDownloads = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_PREFIXO_DOWNLOADS)->first();
        $separadorEmail = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_SEPARADOR_EMAIL)->first();
        $tammaxUpload = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_TAMANHO_MAXIMO_UPLOAD)->first();
        $timezone = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_TIMEZONE)->first();
        return [
            'email_suporte'=> $emailSuporte->valor, 
            'prefix_download' => $prefixDownloads->valor, 
            'separador_email' => $separadorEmail->valor, 
            'tam_max_upload' => $tammaxUpload->valor,
            'timezone' => $timezone->valor
        ];
    }

    public function updateConfig() {
        $emailSuporte = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_EMAIL_SUPORTE)->first();
        $prefixDownloads = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_PREFIXO_DOWNLOADS)->first();
        $separadorEmail = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_SEPARADOR_EMAIL)->first();
        $tammaxUpload = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_TAMANHO_MAXIMO_UPLOAD)->first();
        $timezone = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_TIMEZONE)->first();
        $emailSuporte->valor = Input::get('email_suporte');
        $emailSuporte->save();
        $prefixDownloads->valor = Input::get('prefix_download');
        $prefixDownloads->save();
        $separadorEmail->valor = Input::get('separador_email');
        $separadorEmail->save();
        $tammaxUpload->valor = Input::get('tam_max_upload');
        $tammaxUpload->save();
        $timezone->valor = Input::get('timezone');
        $timezone->save();
        return [
                    'email_suporte'=> $emailSuporte->valor, 
                    'prefix_download' => $prefixDownloads->valor, 
                    'separador_email' => $separadorEmail->valor, 
                    'tam_max_upload' => $tammaxUpload->valor,
                    'timezone' => $timezone->valor
                ];
    }

}
