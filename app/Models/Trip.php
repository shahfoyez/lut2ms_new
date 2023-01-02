<?php

namespace App\Models;

use App\Models\Fuel;
use App\Models\Routex;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $with=['driver'];


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vid');
    }
    public function driver()
    {
        return $this->belongsTo(Employee::class, 'driver');
    }
    public function rout()
    {
        return $this->belongsTo(Routex::class, 'route');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'driver');
    }
    public function onTripVehicle()
    {
        return $this->hasOne(OnTripVehicle::class, 'trip_id');
    }

    // Mutator for automatically be cast to Carbon instances
    protected $dates = [
        'start',
        'end'
    ];
}
