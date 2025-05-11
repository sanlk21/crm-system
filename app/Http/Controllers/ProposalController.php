<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('customer')->latest()->paginate(10)->withQueryString();
        return Inertia::render('Proposals/Index', [
            'proposals' => $proposals
        ]);
    }

    public function create()
    {
        $customers = Customer::all();
        return Inertia::render('Proposals/Create', [
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,approved,rejected',
            'proposal_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:proposal_date'
        ]);

        try {
            DB::beginTransaction();

            Proposal::create($request->all());

            DB::commit();

            return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create proposal: ' . $e->getMessage());
        }
    }

    public function edit(Proposal $proposal)
    {
        $customers = Customer::all();
        return Inertia::render('Proposals/Edit', [
            'proposal' => $proposal,
            'customers' => $customers
        ]);
    }

    public function update(Request $request, Proposal $proposal)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,approved,rejected',
            'proposal_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:proposal_date'
        ]);

        try {
            DB::beginTransaction();

            $proposal->update($request->all());

            DB::commit();

            return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update proposal: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,approved,rejected'
        ]);

        try {
            $proposal->update(['status' => $request->status]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Proposal $proposal)
    {
        try {
            DB::beginTransaction();

            $proposal->delete();

            DB::commit();

            return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete proposal: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Proposal $proposal)
    {
        return Inertia::render('Proposals/Show', [
            'proposal' => $proposal->load('customer') // Eager load the customer relationship
        ]);
    }
}
