<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function station(){
        return $this->belongsTo(Station::class);
    }

    public function parameters(){
        return $this->belongsToMany(Parameter::class, 'parameter_materials');
    }

    public function parameterMaterials(){
        return $this->hasMany(ParameterMaterial::class);
    }

    public function analyses(){
        return $this->hasMany(Analysis::class);
    }

}
