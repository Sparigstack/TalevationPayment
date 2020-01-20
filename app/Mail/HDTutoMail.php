<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class HDTutoMail extends Mailable

{

    use Queueable, SerializesModels;

    /**

     * The user instance.

     *

     * @var Order

     */

    public $user;

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

        return $this->view('HDTutoMail');

    }

}