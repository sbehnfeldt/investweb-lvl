<?php

namespace App\Services;

use App\Models\Fund;
use App\Models\Quote;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class QuoteFetcherService
{

    static private Client $client;

    /**
     * Create a new class instance.
     */
    public function __construct(Client $client)
    {
        self::$client = $client;
    }

    /**
     * @return Client
     */
    public static function getClient(): Client
    {
        return self::$client;
    }

    /**
     * @param  Client  $client
     */
    public static function setClient(Client $client): void
    {
        self::$client = $client;
    }

    static public function processApiResponse($fund, $contents)
    {
        $contents = json_decode($contents, true);
        $contents = $contents['Global Quote'];
        $quote    = Quote::create([
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


    static public function fetchQuotes()
    {
        $funds    = Fund::all();
        $fundMap  = [];
        $quotes   = [];
        $promises = [];
        $funds2   = [];

        // Identify funds which have NO quotes ("unquoted funds") -
        // they take precedence for retrieving quotes
        // from the free API service, which limits the number of free quotes per day
        foreach ($funds as $fund) {
            $fundMap[$fund->id] = $fund;

            $quote = Quote::where('fund_id', $fund->id)
                          ->orderBy('latest_trading_day', 'desc')
                          ->first();
            if ( ! $quote) {
                $url = sprintf(
                    'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=%s&apikey=%s',
                    $fund->symbol,
                    config('app.quotes.api_key')
                );

                $funds2[]   = $fund;
                $promises[] = self::getClient()->getAsync($url);
                break;
            } else {
                // Append quote
                $quotes[] = $quote;
            }
        }

        // Settle unquoted funds
        $responses = Promise\Utils::settle($promises)->wait();
        foreach ($responses as $i => $response) {
            if ('fulfilled' === $response['state']) {
                $body     = $response['value']->getBody();
                $contents = $body->getContents();
                self::processApiResponse($funds2[$i], $contents);
            }
        }

        // Sort $quotes by date ascending
        usort($quotes, function ($a, $b) {
            return $a->latest_trading_day < $b->latest_trading_day;
        });

        foreach ($quotes as $quote) {
            if ($quote->latest_trading_day > date('Y-m-d')) {
                continue;   // break?
            }
            // Fetch quote
            try {
                $url      = sprintf(
                    'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=%s&apikey=%s',
                    $fundMap[$quote->fund_id]->symbol,
                    config('app.quotes.api_key')
                );
                $response = self::getClient()->get($url);
                $body     = $response->getBody();
                $contents = $body->getContents();
                self::processApiResponse($fundMap[$quote->fund_id], $contents);
            } catch (\Exception $e) {
                $err = $e->getMessage();
            }
        }


        return view('quotes');
    }
}
