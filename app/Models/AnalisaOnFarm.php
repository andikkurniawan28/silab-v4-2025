<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisaOnFarm extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variety(){
        return $this->belongsTo(Variety::class);
    }

    public function kawalan(){
        return $this->belongsTo(Kawalan::class);
    }
}
