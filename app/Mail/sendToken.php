<?php

namespace App\Mail;

use App\BenLowery\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendToken extends Mailable
{
    use Queueable, SerializesModels;


    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'benloweryweb@gmail.com';
        $name = 'No reply';
        $subject = 'Login token';

        return $this->view('email.token')
                ->from($address, $name)
                ->subject($subject)
                ->with('token', $this->token);
    }
}
