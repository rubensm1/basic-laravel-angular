<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Configuracoes;
use App\Http\Controllers\LogsController;
use App\Loggador;

class SendMailGlobal extends Mailable implements SendMailInterface
{
    use Queueable, SerializesModels;

    private $obj;
    private $email_suporte;

    private $modo;
    private $string_msgs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj, $modo, $string_msgs)
    {
        $this->obj = $obj;
        if ($this->obj == NULL)
            abort(404, "Objeto não encontrada!");
        $configEmail = Configuracoes::where('nome', Configuracoes::CONFIGURACAO_EMAIL_SUPORTE)->first();
        if ($configEmail != NULL)
            $this->email_suporte = $configEmail->valor;
        $this->modo = $modo;
        $this->string_msgs = $string_msgs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        switch ($this->modo) {
            case Loggador::TIPO_ACAO_CREATE:
                return $this->from(self::EMAIL_REMETENTE)
                    ->view('email.email-'.$this->string_msgs[Loggador::STR_VIEW].'-create')
                    ->subject('#'.$this->obj->id.' Confirmação')
                    ->with([
                        'objeto' => $this->obj, 'email' => $this->email_suporte
                    ]);
            break;
            case Loggador::TIPO_ACAO_UPDATE: 
                return $this->from(self::EMAIL_REMETENTE)
                    ->view('email.email-'.$this->string_msgs[Loggador::STR_VIEW].'-update')
                    ->subject('#'.$this->obj->id.' Confirmação de Alteração')
                    ->with([
                        'objeto' => $this->obj, 'email' => $this->email_suporte
                    ]);
            break;
            case Loggador::TIPO_ACAO_DELETE: 
                return $this->from(self::EMAIL_REMETENTE)
                    ->view('email.email-'.$this->string_msgs[Loggador::STR_VIEW].'-delete')
                    ->subject('#'.$this->obj->id.' Confirmação de Exclusão')
                    ->with([
                        'objeto' => $this->obj, 'email' => $this->email_suporte
                    ]);
            break;
        }
    }
}
