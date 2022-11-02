<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLocation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class, 'vid');
    }
}
