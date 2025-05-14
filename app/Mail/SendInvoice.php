<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        $paymentUrl = route('payment.process', ['invoice' => $this->invoice->id]);
        return $this->subject("Invoice #{$this->invoice->invoice_number} from Laravel CRM")
                    ->view('emails.invoice')
                    ->with([
                        'invoice' => $this->invoice,
                        'paymentUrl' => $paymentUrl
                    ]);
    }
}
