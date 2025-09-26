<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function stockTransactionDetail(){
        return $this->hasMany(StockTransactionDetail::class);
    }

    public function saldo()
    {
        return $this->stockTransactionDetail()
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'masuk' THEN qty ELSE -qty END),0) as saldo")
            ->value('saldo');
    }
}
