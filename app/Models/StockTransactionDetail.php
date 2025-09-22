<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransactionDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stockTransaction(){
        return $this->belongsTo(StockTransaction::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
