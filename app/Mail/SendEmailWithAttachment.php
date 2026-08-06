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
        if (!empty($this->data['curriculo_url'])) {
            // If it's a URL, we might want to attach it if it's a local path or just provide a link in the email.
            // For now, since the user asked for an "external URL", we'll assume it might be a link.
            // But if we want to support attachments, we could try to download it.
            // However, typical Filament/Laravel external URL is just a link.
        }

        $filePath = public_path('curriculo_' . $this->getLanguagePrefix() . '.pdf');

        if (file_exists($filePath)) {
            return [$filePath];
        }

        return [];
    }

    private function getLanguagePrefix(): string
    {
        return $this->data['language'] === 'pt_br' ? 'pt_br' : 'us';
    }

}
