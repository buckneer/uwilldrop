<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billings = Billing::where('user_id', Auth::user()->id)->simplePaginate(2, '*', 'billings')->withQueryString();;
        $allBillings = Billing::where('user_id', Auth::user()->id)->get();
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->simplePaginate(4, '*', 'transactions')->withQueryString();;
        return view('billing.index', compact('billings', 'allBillings', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('billing.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $billing = new Billing;
            $billing->name = $request->name;
            $billing->number = $request->number;
            $billing->expiry_date = $request->expiry_date;
            $billing->cvv = $request->cvv;
            $billing->user_id = auth()->id();

            $billing->save();

            return redirect('billing')->with(['success' => 'Card Saved']);
        } catch (Exception $e) {
            return redirect('ride')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addFunds(Request $request)
    {
        $user = Auth::user();
        $currAmount = $user->wallet;
        $user->wallet = $currAmount + $request->amount;

        $user->save();
        return redirect('billing')->with(['success' => 'Funds Added']);
    }
}
