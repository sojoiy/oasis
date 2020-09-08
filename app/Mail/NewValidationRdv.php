<?php

namespace App\Mail;

use App\Rendezvous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewValidationRdv extends Mailable
{
    use Queueable, SerializesModels;

	public $rendezvous;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Rendezvous $rendezvous)
    {
        $this->rendezvous = $rendezvous;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@cgpic.fr')
                ->view('emails.newvalidationrdv');
    }
}