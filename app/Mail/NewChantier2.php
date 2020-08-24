<?php

namespace App\Mail;

use App\Chantier;
use App\Societe;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewChantier2 extends Mailable
{
    use Queueable, SerializesModels;

	public $chantier;
	public $societe;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Chantier $chantier, Societe $societe)
    {
        $this->chantier = $chantier;
		$this->societe = $societe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@cgpic.fr')
                ->view('emails.newchantier2');
    }
}
