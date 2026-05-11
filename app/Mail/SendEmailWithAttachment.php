<?php

namespace App\Mail;

use App\Services\OllamaService;
use App\Services\TextBoostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailWithAttachment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly array $data)
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['cargo'],
            from: $this->data['user_email'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {


        $html = view('email.' . $this->getLanguagePrefix(), ['data' => $this->data])->render();

        $htmlImprovingService = new OllamaService();

        return new Content(
            htmlString:  $htmlImprovingService->improveHtml($html, $this->data['language']),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [public_path('curriculo_' . $this->getLanguagePrefix() . '.pdf')];
    }

    private function getLanguagePrefix(): string
    {
        return $this->data['language'] === 'pt_br' ? 'pt_br' : 'us';
    }

}
