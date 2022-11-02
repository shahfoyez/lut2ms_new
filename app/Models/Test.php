<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $with = ['employee'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vid');
    }
    public function rout()
    {
        return $this->belongsTo(Routex::class, 'route');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'driver');
    }

    // Mutator for automatically be cast to Carbon instances
    protected $dates = [
        'start',
        'end'
    ];

    return $this->belongsTo(User::class)->withDefault([
        'name' => 'Guest Author',
    ]);
    return $this->hasOne(Order::class)->latestOfMany();
}
