<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = ['open', 'high', 'low', 'price', 'volume', 'latest_trading_day', 'previous_close', 'fund_id'];

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
