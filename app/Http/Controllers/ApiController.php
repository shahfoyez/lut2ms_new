<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function notices()
    {
        $notices = Notice::latest()->get();
        return $notices;
    }
    public function schedule()
    {
        $schedules = Schedule::where('status', 1)->first();
        return $schedules;
    }
}
