<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email extends Mailable {

    use Queueable,
        SerializesModels;

//     
//    /**
//     * The demo object instance.
//     *
//     * @var Demo
//     */
    public $data;

// 
//    /**
//     * Create a new message instance.
//     *
//     * @return void
//     */
    public function __construct($data) {
        $this->data = $data;
        //return $this->data;
    }

// 
//    /**
//     * Build the message.
//     *
//     * @return $this
//     */
    public function build() {
        //$fromAddress, $subject, $fromName, $cc, $ccName, $bcc, $bccName
        $fromAddress = 'team.sprigstack@gmail.com';
//        $subject = 'This is a demo!';
        $fromName = 'Test Verify Link';
        return $this->view($this->data['view'])->with([ 'mail_content' => $this->data['mail_content'] ])
                        ->from($fromAddress, $fromName)
                        //->cc($this->data['cc'], $this->data['ccName'])
                        ->bcc($this->data['bcc'], $this->data['bccName'])
                        ->replyTo($fromAddress, $fromName)
                        ->subject($this->data['subject']);

    }

}
