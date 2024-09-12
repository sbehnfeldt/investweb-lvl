<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Account;
use App\Models\Fund;
use App\Models\Transaction;
use App\Services\TransactionImportService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transactions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $old = $request->old();

        return view('transaction-form', [
            'old' => $old
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        Transaction::create($request->validated());

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function showImport()
    {
        return view('transactions-import', [
            'accounts' => Account::orderBy('description', 'asc')->get(),
            'funds'    => Fund::orderBy('symbol', 'asc')->get()
        ]);
    }

    public function import()
    {
        if ( ! isset($_POST["submit"])) {
            return redirect('/transactions/import');
        }
        $results = TransactionImportService::importFile(
            $_FILES['transactions']['tmp_name'],
            $_POST['account_id'],
            $_POST['fund_id']
        );

        return view('transactions-imported', ['results' => $results]);
    }
}
