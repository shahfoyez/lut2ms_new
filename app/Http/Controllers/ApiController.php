<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function notices()
    {
        $notices = Notice::latest()->first();
        dd($notices);
        return $notices;
    }
    public function schedules()
    {
        $schedules = Schedule::latest()->first();
        return $schedules;

    }
}
