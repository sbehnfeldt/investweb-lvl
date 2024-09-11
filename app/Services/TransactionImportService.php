<?php

namespace App\Services;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use DateTime;

class TransactionImportService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }


    static public function importFile(string $path, int $account_id, int $fund_id): array
    {
        $results = [];
        $file    = fopen($path, 'r');
        if ( ! $file) {
            throw new \Exception(sprintf('Cannot open file "%s"', $path));
        }

        while (false !== ($fields = fgetcsv($file, null, "\t"))) {
            $results[] = self::importRecord($fields, $account_id, $fund_id);
        }

        return $results;
    }


    static public function importRecord(array $fields, int $account_id, int $fund_id): string
    {
        try {
            $transaction = new Transaction([
                'acquired'       => DateTime::createFromFormat('M-d-Y', $fields[0]),
                'quantity'       => $fields[5],
                'avg_cost_basis' => (float)str_replace(['$', ','], '', $fields[6]),
                'account_id'     => $account_id,
                'fund_id'        => $fund_id,
            ]);
            $transaction->save();
        } catch (\Exception $e) {
            return $e->getMessage() . "\n";
        }

        return "OK\n";
    }
}
