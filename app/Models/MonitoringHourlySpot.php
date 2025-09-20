<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonitoringHourlySpot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        static::created(function ($monitoring_hourly) {
            $colName = 'p' . $monitoring_hourly->id;
            if (!Schema::hasColumn('monitoring_hourlies', $colName)) {
                DB::statement("ALTER TABLE monitoring_hourlies ADD COLUMN `$colName` FLOAT NULL AFTER created_at");
                DB::statement("ALTER TABLE monitoring_hourlies ADD INDEX `idx_$colName` (`$colName`)");
            }
        });
    }
}
