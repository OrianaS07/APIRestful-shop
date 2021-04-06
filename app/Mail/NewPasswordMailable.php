<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPasswordMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $password;
    public $subject = 'Nueva Contraseña';
    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct(User $user, $password)
     {
         $this->user = $user;
         $this->password = $password;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
         return $this->markdown('emails.newPassword');
     }
}
