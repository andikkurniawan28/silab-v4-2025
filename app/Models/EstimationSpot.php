<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimationSpot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        static::created(function ($estimation) {
            $colName = 'p' . $estimation->id;
            if (!Schema::hasColumn('estimations', $colName)) {
                DB::statement("ALTER TABLE estimations ADD COLUMN `$colName` FLOAT NULL AFTER created_at");
                DB::statement("ALTER TABLE estimations ADD INDEX `idx_$colName` (`$colName`)");
            }
        });
    }
}
