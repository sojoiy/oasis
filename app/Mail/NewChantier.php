<?php

namespace App\Mail;

use App\Chantier;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewChantier extends Mailable
{
    use Queueable, SerializesModels;

	public $chantier;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Chantier $chantier)
    {
        $this->chantier = $chantier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@cgpic.fr')
                ->view('emails.newchantier');
    }
}
