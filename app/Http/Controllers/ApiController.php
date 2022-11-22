<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->get();
        return $notices;

    }
}
