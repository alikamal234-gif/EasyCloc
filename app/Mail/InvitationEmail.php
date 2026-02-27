<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class InvitationEmail extends Mailable
{
    protected $token;
    public function __construct(string $token) {
        $this->token = $token;
    }
    public function build()
    {
        $token = $this->token;
        return $this
            ->subject('Invitation easyColoc')
            ->view('emails.invitation',compact('token'));
    }
}