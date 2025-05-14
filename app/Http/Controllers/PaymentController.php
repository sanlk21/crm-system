<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function process(Request $request, Invoice $invoice)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Invoice Payment #' . $invoice->invoice_number,
                    ],
                    'unit_amount' => $invoice->amount * 100, // Amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', $invoice->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', $invoice->id),
        ]);

        return redirect()->away($checkout_session->url);
    }

    public function success(Request $request, Invoice $invoice)
    {
        $sessionId = $request->get('session_id');
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            $invoice->update(['status' => 'paid']);
            return Inertia::render('PaymentSuccess', [
                'message' => 'Payment successful! Invoice #' . $invoice->invoice_number . ' has been marked as paid.',
                'invoice' => $invoice
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)->with('error', 'Payment was not completed.');
    }

    public function cancel(Request $request, Invoice $invoice)
    {
        return redirect()->route('invoices.show', $invoice->id)->with('error', 'Payment was cancelled.');
    }
}
