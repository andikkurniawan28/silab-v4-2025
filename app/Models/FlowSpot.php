<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlowSpot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        static::created(function ($flow_spot) {
            $columns = [
                't' . $flow_spot->id,
                'f' . $flow_spot->id,
                'p' . $flow_spot->id,
            ];

            foreach ($columns as $colName) {
                if (!Schema::hasColumn('flows', $colName)) {
                    DB::statement("ALTER TABLE `flows` ADD COLUMN `$colName` FLOAT NULL AFTER `created_at`");
                }
            }
        });
    }
}
