<?php

namespace App\Mail;

use App\Livraison;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewLivraison extends Mailable
{
    use Queueable, SerializesModels;

	public $livraison;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Livraison $livraison)
    {
        $this->livraison = $livraison;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@cgpic.fr')
                ->view('emails.newlivraison');
    }
}
