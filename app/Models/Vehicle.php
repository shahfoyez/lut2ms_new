<?php

namespace App\Models;

use App\Models\GpsDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $with = ['fuels'];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'type');
    }
    public function trips()
    {
        return $this->hasMany(Trip::class, 'vid');
    }
    public function activeTrip()
    {
        return $this->hasOne(Trip::class, 'vid');
    }
    public function fuels()
    {
        return $this->hasMany(Fuel::class, 'vid');
    }
    public function totalFuels()
    {
        return $this->hasMany(Fuel::class, 'vid');
    }
    public function meterEntries()
    {
        return $this->hasMany(Meter::class, 'vid');
    }
    public function firstLastEntries()
    {
        return $this->hasMany(Meter::class, 'vid');
    }
    public function maintenanceEntries()
    {
        return $this->hasMany(Maintenance::class, 'vid');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function location()
    {
        return $this->hasOne(VehicleLocation::class, 'vid');
    }
    public function gpsDevice()
    {
        return $this->hasOne(GpsDevice::class, 'vid');
    }
    // Casting for automatically be cast to Carbon instances
    protected $dates = [
        'fuels_max_date',
        'meter_entries_max_date',
        'maintenance_entries_max_from'
    ];
}
