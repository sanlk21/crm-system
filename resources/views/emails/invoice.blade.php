<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .button { background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_number }}</h1>
    <p>Dear {{ $invoice->customer->name ?? 'Customer' }},</p>
    <p>Thank you for your business. Below are the details of your invoice:</p>
    <ul>
        <li><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</li>
        <li><strong>Issue Date:</strong> {{ $invoice->issue_date }}</li>
        <li><strong>Due Date:</strong> {{ $invoice->due_date }}</li>
        <li><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</li>
        <li><strong>Status:</strong> {{ $invoice->status }}</li>
        <li><strong>Notes:</strong> {{ $invoice->notes ?? 'N/A' }}</li>
    </ul>
    <p>Please make your payment by clicking the button below:</p>
    <a href="{{ $paymentUrl }}" class="button">Pay Now ({{ number_format($invoice->amount, 2) }})</a>
    <p>If you have any questions, feel free to contact us at {{ config('mail.from.address') }}.</p>
    <p>Best regards,<br>Laravel CRM Team</p>
</body>
</html>
