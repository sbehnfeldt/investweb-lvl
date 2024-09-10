<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        $apiKey   = config('app.quotes.api_key');
//        $contents = file_get_contents(
//            'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $id . '&apikey=' . $apiKey
//        );
//        $contents = json_decode($contents, true);
//
//        return $contents['Global Quote']['05. price'];

        return rand(100, 10000) / 100;
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
}
