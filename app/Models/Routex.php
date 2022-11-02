<?php

namespace App\Models;

use App\Models\Stoppage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Routex extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $with=['stoppages'];
    public function stoppages()
    {
        return $this->hasMany(Stoppage::class, 'route');
    }
}
