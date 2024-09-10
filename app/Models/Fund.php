<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol', 'description'];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
