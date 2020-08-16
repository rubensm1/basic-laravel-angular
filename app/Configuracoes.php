<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracoes extends Model implements Loggador
{
    const CONFIGURACAO_EMAIL_SUPORTE = "EMAIL_SUPORTE";
    const CONFIGURACAO_PREFIXO_DOWNLOADS = "PREFIXO_DOWNLOADS";
    const CONFIGURACAO_TAMANHO_MAXIMO_UPLOAD = "TAMANHO_MAXIMO_UPLOAD";
    const CONFIGURACAO_SEPARADOR_EMAIL = "SEPARADOR_EMAIL";
    const CONFIGURACAO_TIMEZONE = "TIMEZONE";

    protected $fillable = [
        'nome',
        'valor'
    ];

    protected $visible =  [
        'nome',
        'valor'
    ];

    
    public function getId() {
        return $this->nome;
    }
    public function getLogDescricao() {
        return "";
    }
}
