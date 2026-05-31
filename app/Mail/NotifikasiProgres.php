<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\Projectprogress;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiProgres extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Project $project, public Projectprogress $progres) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[SIMP-PRO] Update Progres Proyek: ' . $this->project->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-progres',
        );
    }
}