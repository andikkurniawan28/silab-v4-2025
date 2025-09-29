<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parameter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function materials(){
        return $this->belongsToMany(Material::class, 'parameter_materials');
    }

    protected static function booted()
    {
        static::created(function ($parameter) {
            $colName = 'p' . $parameter->id;
            $colNameX = 'p' . $parameter->id .'_old';
            if (!Schema::hasColumn('analyses', $colName)) {
                DB::statement("ALTER TABLE analyses ADD COLUMN `$colName` FLOAT NULL AFTER is_verified");
            }
            if (!Schema::hasColumn('analysis_change_requests', $colName)) {
                DB::statement("ALTER TABLE analysis_change_requests ADD COLUMN `$colName` FLOAT NULL AFTER updated_at");
                DB::statement("ALTER TABLE analysis_change_requests ADD COLUMN `$colNameX` FLOAT NULL AFTER updated_at");
            }
        });
    }
}
