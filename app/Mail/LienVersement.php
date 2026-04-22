<?php

namespace App\Mail;

use App\Models\Versement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LienVersement extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Versement $versement
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre lien de paiement — versement n°' . $this->versement->numero_versement,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.LienVersement',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
