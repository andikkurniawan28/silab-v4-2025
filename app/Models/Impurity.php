<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Impurity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($impurity) {
            $colName = 'p' . $impurity->id;
            if (!Schema::hasColumn('analisa_on_farms', $colName)) {
                DB::statement("ALTER TABLE analisa_on_farms ADD COLUMN `$colName` TINYINT NULL AFTER updated_at");
                DB::statement("ALTER TABLE analisa_on_farms ADD INDEX `idx_$colName` (`$colName`)");
            }
        });
    }
}
