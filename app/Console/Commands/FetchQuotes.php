<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-quotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch quotes from an API and store in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
