<?php

namespace App\Mail;

interface SendMailInterface
{
    const EMAIL_REMETENTE = "nao-responda@inscricao.ead.ufgd.edu.br";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj,$modo);

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build();

}