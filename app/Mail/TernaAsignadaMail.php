<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Terna;

class TernaAsignadaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $usuario;
    public $terna;
    public $esEstudiante;
    public $miembros;

    /**
     * Create a new message instance.
     */
    public function __construct(User $usuario, Terna $terna, bool $esEstudiante, array $miembros)
    {
        $this->usuario = $usuario;
        $this->terna = $terna;
        $this->esEstudiante = $esEstudiante;
        $this->miembros = $miembros;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Has sido asignado a una Terna',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.terna-asignada',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}