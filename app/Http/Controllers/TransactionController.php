<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['invoice', 'customer'])->latest()->paginate(10)->withQueryString();
        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        $invoices = Invoice::all();
        $customers = Customer::all();
        return Inertia::render('Transactions/Create', [
            'invoices' => $invoices,
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'customer_id' => 'required|exists:customers,id',
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed'
        ]);

        try {
            DB::beginTransaction();

            Transaction::create($request->all());

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        return Inertia::render('Transactions/Show', [
            'transaction' => $transaction->load(['invoice', 'customer'])
        ]);
    }

    public function edit(Transaction $transaction)
    {
        $invoices = Invoice::all();
        $customers = Customer::all();
        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction,
            'invoices' => $invoices,
            'customers' => $customers
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'customer_id' => 'required|exists:customers,id',
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed'
        ]);

        try {
            DB::beginTransaction();

            $transaction->update($request->all());

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update transaction: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed'
        ]);

        try {
            $transaction->update(['status' => $request->status]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            $transaction->delete();

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete transaction: ' . $e->getMessage())->withInput();
        }
    }
}
