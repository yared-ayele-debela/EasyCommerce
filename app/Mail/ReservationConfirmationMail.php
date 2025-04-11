<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF receipt
        $pdf = Pdf::loadView('Hotel.dashboard.reservations.receipt', ['reservation' => $this->reservation]);
        return $this->subject('Reservation Confirmation')
                    ->view('hotel.emails.reservation_confirmation')
                    ->attachData($pdf->output(), "receipt_{$this->reservation->id}.pdf");
    }
}