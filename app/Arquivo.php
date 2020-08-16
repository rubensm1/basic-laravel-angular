<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model implements Loggador
{
    protected $table = 'arquivos';
    
    protected $fillable = [
        'name',
        'hash',
        'extension',
        'path',
        'ativo'
    ];

    
    public function getId() {
        return $this->id;
    }
    public function getLogDescricao() {
        return "";
    }
}
