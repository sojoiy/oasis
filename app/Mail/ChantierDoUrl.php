<?php

namespace App\Mail;

use App\EquipierDo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChantierDoUrl extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EquipierDo $equipier)
    {
        $this->equipier = $equipier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@cgpic.fr')
                ->view('emails.chantierdourl', ["equipier" => $this->equipier]);
    }
}
