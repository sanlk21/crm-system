<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(10)->withQueryString();
        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices
        ]);
    }

    public function create()
    {
        $customers = Customer::all();
        return Inertia::render('Invoices/Create', [
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|max:255|unique:invoices',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,cancelled',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $invoice = Invoice::create($request->all());

            // Send invoice email if status is 'sent'
            if ($request->status === 'sent') {
                $customer = $invoice->customer;
                if (!$customer || !$customer->email) {
                    throw new \Exception('Customer email is not set.');
                }
                Mail::to($customer->email)->send(new SendInvoice($invoice));
                if (Mail::failures()) {
                    throw new \Exception('Failed to send invoice email.');
                }
            }

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        return Inertia::render('Invoices/Show', [
            'invoice' => $invoice->load('customer')
        ]);
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        return Inertia::render('Invoices/Edit', [
            'invoice' => $invoice,
            'customers' => $customers
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number,' . $invoice->id,
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,cancelled',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $invoice->update($request->all());

            // Send invoice email if status is changed to 'sent'
            if ($request->status === 'sent' && $invoice->wasChanged('status')) {
                $customer = $invoice->customer;
                if (!$customer || !$customer->email) {
                    throw new \Exception('Customer email is not set.');
                }
                Mail::to($customer->email)->send(new SendInvoice($invoice));
                if (Mail::failures()) {
                    throw new \Exception('Failed to send invoice email.');
                }
            }

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update invoice: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,paid,cancelled'
        ]);

        try {
            $invoice->update(['status' => $request->status]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $invoice->delete();

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete invoice: ' . $e->getMessage())->withInput();
        }
    }

    public function resendInvoice(Invoice $invoice)
    {
        try {
            if (!$invoice->customer || !$invoice->customer->email) {
                return back()->with('error', 'Customer email is not set.');
            }
            Mail::to($invoice->customer->email)->send(new SendInvoice($invoice));
            if (Mail::failures()) {
                return back()->with('error', 'Failed to resend invoice email.');
            }
            return back()->with('success', 'Invoice email resent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend invoice: ' . $e->getMessage());
        }
    }
}
