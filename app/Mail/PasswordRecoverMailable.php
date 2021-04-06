<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordRecoverMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $subject = 'Restablecer Contraseña';
    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct(User $user)
     {
         $this->user = $user;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
         return $this->markdown('emails.passwordRecover');
     }
}
