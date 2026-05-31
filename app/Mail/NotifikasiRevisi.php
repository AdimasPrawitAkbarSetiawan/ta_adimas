<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiRevisi extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Project $project, public string $catatan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[SIMP-PRO] Proyek Perlu Direvisi: ' . $this->project->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-revisi',
        );
    }
}