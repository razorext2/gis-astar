<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendDailyReportToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $id = null;

    public ?string $namaPenanggungJawab = null;

    public ?string $namaPerusahaan = null;

    public ?string $namaStaff = null;

    /**
     * Create a new message instance.
     */
    public function __construct($id, $namaPenanggungJawab, $namaPerusahaan, $namaStaff)
    {
        $this->id = $id;
        $this->namaPenanggungJawab = $namaPenanggungJawab;
        $this->namaPerusahaan = $namaPerusahaan;
        $this->namaStaff = $namaStaff;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: "Rekap Laporan $this->namaStaff");
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.daily-report-view',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('pdf', $this->id.'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
