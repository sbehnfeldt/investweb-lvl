<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['acquired', 'quantity', 'avg_cost_basis', 'account_id', 'fund_id'];

}
