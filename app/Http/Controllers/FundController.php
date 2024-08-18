<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\UpdateFundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('funds');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $old = $request->old();

        return view('fund-form', [
            'old' => $old
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreFundRequest $request)
    {
        Fund::create($request->validated());

        return redirect()->route('funds.index')->with('success', 'Fund created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        return view('fund', [
            'fund' => $fund
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund)
    {
        return view('fund-form', [
            'fund' => $fund
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundRequest $request, Fund $fund)
    {
        $fund->update($request->validated());
        $fund->save();

        return redirect()->route('funds.index')->with('success', 'Fund updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund)
    {
        if ( ! Gate::allows('delete-fund', $fund)) {
            abort(403);
        }

        $fund->delete();

        return '[]';
    }
}
