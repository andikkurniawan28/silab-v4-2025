<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonitoringShiftlySpot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        static::created(function ($monitoring_shiftly) {
            $colName = 'p' . $monitoring_shiftly->id;
            if (!Schema::hasColumn('monitoring_shiftlies', $colName)) {
                DB::statement("ALTER TABLE monitoring_shiftlies ADD COLUMN `$colName` FLOAT NULL AFTER created_at");
            }
        });
    }
}
