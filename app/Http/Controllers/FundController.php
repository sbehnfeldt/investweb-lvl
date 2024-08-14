<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\UpdateFundRequest;

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
    public function create()
    {
        return view('fund-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundRequest $request)
    {
        return 'Store new fund';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund)
    {
        //
    }
}
