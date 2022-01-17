<?php

namespace App\Mail;

use App\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    protected $admin;
    protected $newPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $newPassword)
    {
        //
        $this->admin = $admin;
        $this->newPassword = $newPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@mr-tech.tech','News System')
        ->subject("News System | Password Reset")
        ->to($this->admin->email)
        ->with([
            'newPassword'=>$this->newPassword,
            'adminName'=>$this->admin->name
        ])
        ->markdown('emails.auth.reset_password');
    }
}
