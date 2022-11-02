<?php

namespace App\Models;

use App\Models\Routex;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stoppage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sRoute()
    {
        return $this->belongsTo(Routex::class, 'route');
    }
}
