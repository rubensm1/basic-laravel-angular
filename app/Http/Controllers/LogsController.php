<?php

namespace App\Http\Controllers;

use App\Configuracoes;
use App\Loggador;
use App\Log;
use App\Mail\SendMailGlobal;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class LogsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    const FLAGS_REGISTROS_LOGS = [
        'Inscricao'         => [Loggador::TIPO_ACAO_CREATE => true , Loggador::TIPO_ACAO_UPDATE => true , Loggador::TIPO_ACAO_DELETE => true ],
        'RecursoInscricao'  => [Loggador::TIPO_ACAO_CREATE => true , Loggador::TIPO_ACAO_UPDATE => true , Loggador::TIPO_ACAO_DELETE => true ],
    ];

    const FLAGS_ENVIO_EMAILS = [
        'Inscricao'         => [Loggador::TIPO_ACAO_CREATE => true , Loggador::TIPO_ACAO_UPDATE => true , Loggador::TIPO_ACAO_DELETE => false],
        'RecursoInscricao'  => [Loggador::TIPO_ACAO_CREATE => true , Loggador::TIPO_ACAO_UPDATE => true , Loggador::TIPO_ACAO_DELETE => true ],
    ];

    const STRINGS_MSGS = [
        'Inscricao'         => [Loggador::STR_VIEW => 'inscricao'],
        'RecursoInscricao'  => [Loggador::STR_VIEW => 'recurso-inscricao'],
    ];
    
    private function usuarioLogado() {
        $hackid = App::make('UsuariosService')->getUsuarioAdminHackId();
        if ($hackid)
            return User::find($hackid);
        return App::make('UsuariosService')->usuarioLogado();
    }
    public function geraLog(Loggador $obj, $tipo_acao, $objAnt = null, $listaInteressados = []) {
        $log = new Log();
        $log->user_id = $this->usuarioLogado()->id;
        $log->tipo_acao = $tipo_acao;
        $log->classe = substr(get_class($obj), strlen('App/') );
        //$log->acao = "[".$l->getLogDescricao()."]";
        //$log->save();

        foreach (self::FLAGS_REGISTROS_LOGS as $nome_classe => $frl ) {
            if ($log->classe == $nome_classe) {
                foreach ($frl as $tp_ac => $flag) {
                    if ($tp_ac == $log->tipo_acao && $flag) {
                        // executa registro do log
                        switch ($log->tipo_acao) {
                            case Loggador::TIPO_ACAO_CREATE:
                            case Loggador::TIPO_ACAO_DELETE:
                                $log->acao = "[".$obj->getLogDescricao()."]";
                                $log->save();
                            break;
                            case Loggador::TIPO_ACAO_UPDATE:
                                if ($objAnt != null) {
                                    $log->acao = "[".$objAnt->getLogDescricao(). ",\n" . $obj->getLogDescricao()."]";
                                    $log->save();
                                }
                            break;
                        }
                        break;
                    }
                }
                break;
            }
        }
        foreach (self::FLAGS_ENVIO_EMAILS as $nome_classe => $fee ) {
            if ($log->classe == $nome_classe) {
                foreach ($fee as $tp_ac => $flag) {
                    if ($tp_ac == $log->tipo_acao && $flag) {
                        // executa envio email
                        $configEmail = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_EMAIL_SUPORTE)->first();
                        $configSeparadorEmail = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_SEPARADOR_EMAIL)->first();
                        if (config('app.debug')) {
                            //return ['objeto_id' => $obj->getId(), 'email' => ($configEmail == NULL ? "" : $configEmail->valor ), 'debug' => true];
                        }
                        else {
                            $getEmails = function(User $u) {
                                return $u->email;
                            };
                            $emailsCC = array_map($getEmails, $listaInteressados);
                            //$emailsCC = array_merge( array_map('trim', explode($configSeparadorEmail, $configEmail->valor)) , array_map($getEmails, $listaInteressados)) ;
                            Mail::to($log->usuario->email)
                                ->cc($configEmail != null ? $emailsCC  : "")
                                ->send(new SendMailGlobal($obj, $tipo_acao, self::STRINGS_MSGS[$nome_classe]));
                            //return ['objeto_id' => $obj->getId(), 'email' => ($configEmail == NULL ? "" : $configEmail->valor ), 'debug' => false];
                            //return Redirect::action('SalaController@success');
                        }
                        break;
                    }
                }
                break;
            }
        }
        return ['objeto_id' => $obj->getId(), 'email' => ($configEmail == NULL ? "" : $configEmail->valor ), 'debug' => config('app.debug')];
        return true;
    }

    public function viewMailDebug (Request $request, $classe, $id, $modo)
    {
        if (config('app.debug')) {
            if (!$id) {
                abort(400, "Objeto não Encontrado!");
            }
            $objeto = null;
            $classRef = 'App\\'.$classe;
            if ($modo == Loggador::TIPO_ACAO_DELETE) {
                $objeto = new $classRef();
                $objeto->id = $id;
            }
            else {
                $objeto = $classRef::find($id);
                if (!$objeto || !$objeto->id) {
                    abort(400, "Objeto não Encontrado!");
                }
            }
            
            $configEmail = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_EMAIL_SUPORTE)->first();

            switch ($modo) {
                case Loggador::TIPO_ACAO_CREATE: 
                    return view('email.email-'.self::STRINGS_MSGS[$classe][Loggador::STR_VIEW].'-create', ['objeto' => $objeto, 'email' => ($configEmail == NULL ? "" : $configEmail->valor )]);
                break;
                case Loggador::TIPO_ACAO_UPDATE: 
                    return view('email.email-'.self::STRINGS_MSGS[$classe][Loggador::STR_VIEW].'-update', ['objeto' => $objeto, 'email' => ($configEmail == NULL ? "" : $configEmail->valor )]);
                break;
                case Loggador::TIPO_ACAO_DELETE: 
                    return view('email.email-'.self::STRINGS_MSGS[$classe][Loggador::STR_VIEW].'-delete', ['objeto' => $objeto, 'email' => ($configEmail == NULL ? "" : $configEmail->valor )]);
                break;
            }
        }
        else 
            abort (401, "Não autorizado em produção!");
    }

    public function geraLogCreate(Loggador $l) {
        $log = new Log();
        $log->usuario = $this->usuarioLogado();
        $log->tipo_acao = Loggador::TIPO_ACAO_CREATE;
        $log->classe = substr(get_class($l), strlen('App/') );
        $log->acao = "[".$l->getLogDescricao()."]";
        $log->save();
        return true;
    }
    public function geraLogUpdate(Loggador $a, Loggador $b) {
        $log = new Log();
        $log->usuario = $this->usuarioLogado();
        $log->tipo_acao = Loggador::TIPO_ACAO_UPDATE;
        $log->classe = substr(get_class($a), strlen('App/') );
        $log->acao = "[".$a->getLogDescricao(). ",\n" . $b->getLogDescricao()."]";
        $log->save();
        return true;
    }
    public function geraLogDelete(Loggador $l) {
        $log = new Log();
        $log->usuario = $this->usuarioLogado();
        $log->tipo_acao = Loggador::TIPO_ACAO_DELETE;
        $log->classe = substr(get_class($l), strlen('App/') );
        $log->acao = "[".$l->getLogDescricao()."]";
        $log->save();
        return true;
    }
}
