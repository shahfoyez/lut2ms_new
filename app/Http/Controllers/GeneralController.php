<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(){
        // dd($stuReq);
        return view('dashboard');
    }
    public function logbook(){
        $vehicles = Vehicle::withSum('fuels', 'quantity')
            ->withSum('totalFuels', 'quantity')
            ->withSum('fuels', 'cost')
            ->withCount('trips')
            ->withMax('firstLastEntries', 'meter_entry')
            ->withMin('firstLastEntries', 'meter_entry')
            ->withMax('meterEntries', 'meter_entry')
            ->withMin('meterEntries', 'meter_entry')
            ->get();
        // dd($vehicles);
        return view('summery', [
            'vehicles' => $vehicles
        ]);
    }
    public function summeryFilter()
    {
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Vehicle::query();
        if(request()->input('date')){
            $vehicles = Vehicle::withSum(['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'quantity')
            ->withSum('totalFuels', 'quantity')
            ->withSum(
                ['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'cost'
            )
            ->withMax(
                ['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'date'
            )
            ->withCount(
                ['trips' => fn($query) => $query->whereBetween('start', [$start, $end])],'start'
            )

            ->withMax('firstLastEntries', 'meter_entry')
            ->withMin('firstLastEntries', 'meter_entry')
            ->withMax(
                ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
            )
            ->withMin(
                ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
            )->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        // dd($trips);
        return view('summery', [
            'vehicles' => $vehicles,
            'start' => $start,
            'end' => $end
        ]);

    }
}
