<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Proposal;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $customerCount = Customer::count();
        $invoiceCount = Invoice::count();
        $proposalCount = Proposal::count();
        $proposalStatuses = Proposal::select('status')
            ->groupBy('status')
            ->pluck('status')
            ->mapWithKeys(function ($status) {
                return [$status => Proposal::where('status', $status)->count()];
            });

        return Inertia::render('Dashboard', [
            'customerCount' => $customerCount,
            'invoiceCount' => $invoiceCount,
            'proposalCount' => $proposalCount,
            'proposalStatuses' => $proposalStatuses,
        ]);
    }
}
