<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class registerSuccessful extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataRequest)
    {
        $this->data = $dataRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(subject:"Registro Efetuado com Sucesso");


        $this->to(strval($this->data->email),strval($this->data->nome));//convertendo para string por questão de segurança;
        return $this->view('mail.register-successful',[
            'user' => $this->data->nome
        ]);
    }
}
