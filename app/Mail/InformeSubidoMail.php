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

class InformeSubidoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $alumno;
    public $docente;
    public $nombreArchivo;
    public $descripcion;

    /**
     * Create a new message instance.
     */
    public function __construct(User $alumno, User $docente, $nombreArchivo, $descripcion)
    {
        $this->alumno = $alumno;
        $this->docente = $docente;
        $this->nombreArchivo = $nombreArchivo;
        $this->descripcion = $descripcion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo informe subido por alumno',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.informe-subido',
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