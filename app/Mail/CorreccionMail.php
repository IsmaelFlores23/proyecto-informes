<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Revision;

class CorreccionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $alumno;
    public $docente;
    public $revision;
    public $nombreArchivo;

    /**
     * Create a new message instance.
     */
    public function __construct(User $alumno, User $docente, Revision $revision, $nombreArchivo)
    {
        $this->alumno = $alumno;
        $this->docente = $docente;
        $this->revision = $revision;
        $this->nombreArchivo = $nombreArchivo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva corrección en tu informe',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.correccion',
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