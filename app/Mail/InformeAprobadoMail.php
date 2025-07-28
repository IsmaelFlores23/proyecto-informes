<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Informe;

class InformeAprobadoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $alumno;
    public $informe;
    public $docentes;

    /**
     * Create a new message instance.
     */
    public function __construct(User $alumno, Informe $informe, $docentes)
    {
        $this->alumno = $alumno;
        $this->informe = $informe;
        $this->docentes = $docentes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu informe ha sido aprobado por todos los docentes!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.informe-aprobado',
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