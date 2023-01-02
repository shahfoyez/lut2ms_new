<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnTripVehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vid');
    }
}
