<?php

namespace App\Mail;

use App\Models\PriceAlert;
use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceAlertTriggered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public PriceAlert $alert,
        public CarbonInterface $triggeredAt
    ) {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alerta de preço atingido - ' . $this->alert->asset->code
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.price-alert-triggered',
            with: [
                'alert'         => $this->alert,
                'asset'         => $this->alert->asset,
                'triggeredAt'   => $this->triggeredAt,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
