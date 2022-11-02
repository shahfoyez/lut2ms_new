<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function employees(){
        return $this->hasMany(Employee::class, 'designation');
    }
}
