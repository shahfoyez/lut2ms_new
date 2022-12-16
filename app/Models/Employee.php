<?php

namespace App\Models;

use App\Models\Trip;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function departmentR(){
        return $this->belongsTo(Department::class, 'department');
    }
    public function designationR(){
        return $this->belongsTo(Designation::class, 'designation');
    }
    public function trips(){
        return $this->hasMany(Trip::class, 'driver');
    }
}
