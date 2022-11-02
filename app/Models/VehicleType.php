<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleType extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'type');
    }
}
