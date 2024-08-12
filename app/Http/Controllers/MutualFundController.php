<?php

namespace App\Http\Controllers;


use App\Models\MutualFund;

class MutualFundController extends Controller
{
    public function index()
    {
        return view('mutual_funds', [
            'mutualFunds' => MutualFund::all()
        ]);

    }
}
