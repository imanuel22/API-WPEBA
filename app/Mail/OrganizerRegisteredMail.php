<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizerRegisteredMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $randomPassword;

    public function __construct($user, $randomPassword)
    {
        $this->user = $user;
        $this->randomPassword = $randomPassword;
    }

    public function build()
    {
        return $this->subject('Your Organizer Account Details')
                    ->view('emails.organizer_registered'); // Pastikan Anda membuat file view email
    }
}
