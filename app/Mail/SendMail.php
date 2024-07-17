<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $SendMailData;
    public function __construct($SendMailData)
    {
        //
        $this->SendMailData = $SendMailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('แจ้งสถานะการสมัครเรียนผ่านระบบ Young Smart')
        ->view('sendmail.sendmail' );
        // return $this->view('view.name');
    }
}
