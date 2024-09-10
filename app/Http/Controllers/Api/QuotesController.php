<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Quote::with('fund')->get();
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
     *
     * @param  string  $symbol  Fund symbol
     */
    public function show(string $symbol)
    {
//        return rand(100, 10000) / 100;
        $quote = Quote::whereHas('fund', function ($query) use ($symbol) {
            $query->where('symbol', $symbol);
        })
                      ->orderByDesc('latest_trading_day')
                      ->first();

        if ( ! $quote) {
            $fund = Fund::where('symbol', $symbol)->first();

            $apiKey   = config('app.quotes.api_key');
            $contents = file_get_contents(
                'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $symbol . '&apikey=' . $apiKey
            );
            $contents = json_decode($contents, true);
            $contents = $contents['Global Quote'];

            $quote = Quote::create([
                'open'               => $contents['02. open'],
                'high'               => $contents['03. high'],
                'low'                => $contents['04. low'],
                'price'              => $contents['05. price'],
                'volume'             => $contents['06. volume'],
                'latest_trading_day' => $contents['07. latest trading day'],
                'previous_close'     => $contents['08. previous close'],
                'fund_id'            => $fund->id
            ]);
            $quote->save();
        }

        return $quote;
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

    public function latest()
    {
        // Yuck.  Return the most recent quote for each fund.
        return Quote::select('quotes.*', 'funds.*')
                    ->join('funds', 'funds.id', '=', 'quotes.fund_id')
                    ->join(
                        DB::raw(
                            '(SELECT fund_id, MAX(latest_trading_day) as latest_trading_day FROM quotes GROUP BY fund_id) as recent_quotes'
                        ),
                        function ($join) {
                            $join->on('quotes.fund_id', '=', 'recent_quotes.fund_id')
                                 ->on('quotes.latest_trading_day', '=', 'recent_quotes.latest_trading_day');
                        }
                    )
                    ->get();
    }
}
