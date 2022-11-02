<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vid');
    }
    // Attribute Casting for automatically be cast to Carbon instances
    protected $dates = [
        'from',
        'to'
    ];
}
