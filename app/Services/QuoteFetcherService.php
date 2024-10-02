<?php

namespace App\Services;

use App\Models\Fund;
use App\Models\Quote;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Log;

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

    static public function callQuoteApi($funds)
    {
        $promises = [];
        foreach ($funds as $fund) {
            $url = sprintf(
                'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=%s&apikey=%s',
                $fund->symbol,
                config('app.quotes.api_key')
            );

            $promises[] = self::getClient()->getAsync($url);
        }

        return $promises;
    }


    static public function settleQuotePromises($funds, $promises)
    {
        $quotes    = [];
        $responses = Promise\Utils::settle($promises)->wait();

        foreach ($responses as $i => $response) {
            if ('fulfilled' === $response['state']) {
                try {
                    $body                       = $response['value']->getBody();
                    $contents                   = $body->getContents();
                    $quote                      = self::processApiResponse($funds[$i], $contents);
                    $quotes[$funds[$i]->symbol] = $quote;
                    Log::info(sprintf("%s: %s  $%.2f", $funds[$i]->symbol, date('Y-m-d'), $quote->price));
                } catch (\Exception $e) {
                    $temp = json_decode($e->getMessage(), true);
                    if (array_key_exists('Note', $temp)) {
                        $msg = sprintf("Note - %s", $temp['Note']);
                    } elseif (array_key_exists('Information', $temp)) {
                        $msg = sprintf("Information - %s", $temp['Information']);
                    } else {
                        $msg = $e->getMessage();
                    }
                    Log::error(sprintf("%s: %s", $funds[$i]->symbol, $msg));
                    $quotes[$funds[$i]->symbol] = $msg;
                }
            } else {
                $quotes[$funds[$i]->symbol] = $response['reason']->getMessage();
                Log::error($response['reason']->getMessage());
            }
        }

        return $quotes;
    }

    static public function processApiResponse($fund, $contents)
    {
        $contents = json_decode($contents, true);
        if ( ! array_key_exists('Global Quote', $contents)) {
            throw new \Exception(json_encode($contents));
        }
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

        return $quote;
    }


    static public function fetchQuotes()
    {
        Log::info('Fetching quotes');
        $quoted   = [];
        $unquoted = [];

        // Identify funds which have NO quotes ("unquoted funds") -
        // they take precedence for retrieving quotes
        // from the free API service, which limits the number of free quotes per day
        foreach (Fund::all() as $fund) {
            $quote = Quote::where('fund_id', $fund->id)
                          ->orderBy('latest_trading_day', 'desc')
                          ->first();

            if ( ! $quote) {
                $unquoted[] = $fund;
            } else {
                // Group $quoted funds by latest trading day
                if ( ! isset($quoted[$quote->latest_trading_day])) {
                    $quoted[$quote->latest_trading_day] = [];
                }
                $quoted[$quote->latest_trading_day][] = $fund;
            }
        }

        // Fetch quotes for unquoted funds
        $promises = self::callQuoteApi($unquoted);
        $unquoted = self::settleQuotePromises($unquoted, $promises);


        // Sort all identified "latest trading day" dates chronologically,
        // so that the funds with the "stalest" quotes get updated first
        $dates = array_keys($quoted);
        usort($dates, function ($a, $b) {
            return $a <=> $b;
        });

        $quotesByDate = [];
        foreach ($dates as $date) {
            if ($date > date('Y-m-d')) {
                // This will probably never happen
                break;
            }
            $promises            = self::callQuoteApi($quoted[$date]);
            $quotesByDate[$date] = self::settleQuotePromises($quoted[$date], $promises);
        }

        return view('quotes-fetched', [
            'unquoted' => $unquoted,
            'quotes'   => $quotesByDate
        ]);
    }
}
