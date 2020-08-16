<?php

namespace App;

/**
 * @method string getLogDescricao();
 */
interface Loggador
{
    const TIPO_ACAO_CREATE = "CREATE";
    const TIPO_ACAO_UPDATE = "UPDATE";
    const TIPO_ACAO_DELETE = "DELETE";

    const STR_VIEW = 'view';

    public function getLogDescricao();

    public function getId();
}