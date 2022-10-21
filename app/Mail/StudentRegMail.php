<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentRegMail extends Mailable
{
    use Queueable, SerializesModels;

    private $ActionLink;
    private $username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link,$username)
    {
        $this->ActionLink   = $link;
        $this->username     = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->from('info@edumind.lk', 'admin')
            ->subject('Registration - edumind.lk')
            ->view('email.student-activation')
            ->with ('actionLink',$this->ActionLink)
            ->with ('username',$this->username);
    }
}
