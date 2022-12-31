<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fuel;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Maintenance;
use App\Helpers\TripsHelper;
use Illuminate\Http\Request;
use App\Models\OnTripVehicle;



class GeneralController extends Controller
{
    public function index(){
        // dd($stuReq);
        $onRoad =  $vehicles = Vehicle::where('status', 'trip')
        ->latest()
        ->get()->count();
        $onBoard = Vehicle::where('status', 'available')
        ->latest()
        ->get()->count();
        $maintenance = Vehicle::where('status', 'maintenance')
        ->latest()
        ->get()->count();



        $drivers = Employee::where('designation', 1)
            ->withCount(['trips' => function($query) {
                $query->where('status', 1);
            }])
            ->orderBy('trips_count', 'DESC')
            // ->having('trips_count', '>', 0)
            ->take(6)
            ->get();

        // app/Helpers/helper
        // to get trips & fuels data
        $tripsData = tripsData();
        $fuelsData = fuelsData();
        // dd($fuelsData);

        $maintenanceStats = Maintenance::selectRaw("year(`from`) AS year, month(`from`) AS month, monthname(`from`) AS monthName, sum(cost) AS totalCost")
            ->groupByRaw("monthName(`from`)")
            ->groupByRaw("year(`from`)")
            ->groupByRaw("month(`from`)")
            ->orderBy('year', "DESC")
            ->orderBy('month', "DESC")
            ->take(12)
            ->get();


        $labels = array();
        $costValues = array();
        $totalCost = 0;
        $avgCost = 0;
        $curCost = 0;
        $lastCost = 0;
        $curFound = 0;
        $curYear = date("Y");
        $curMonth = date("m");

        $lastMonth = '';
        $thisMonth = '';

        if($maintenanceStats->count() > 0){
            foreach($maintenanceStats as $stats){
                if($curMonth == $stats->month && $curYear == $stats->year){
                    $curCost = $stats->totalCost;
                    $thisMonth = $stats->monthName;
                    $curFound = 1;
                }elseif($curFound == 1){
                    $lastCost = $stats->totalCost;
                    $curFound = 2;
                    $lastMonth = $stats->monthName;
                }
                $year = substr($stats->year, -2);
                $month = substr($stats->monthName, 0, 3);
                $label = $month." ".$year;
                $totalCost += $stats->totalCost;
                array_push($labels, $label);
                array_push($costValues, $stats->totalCost);
            }
            $avgCost = $totalCost/sizeof($labels);
        }
        $maintenanceData = array(
            'totalCost' => (int)$totalCost,
            'avgCost' =>  (int)$avgCost,
            'curCost' => $curCost,
            'lastCost' => $lastCost,
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth
        );

        $data = array(
            'onRoad' => $onRoad,
            'onBoard' => $onBoard,
            'maintenance' => $maintenance,
        );
        return view('dashboard', [
            'data' => $data,
            'maintenanceData' => $maintenanceData,
            'drivers' => $drivers,
            'MaintenanceStats' => $maintenanceStats,
            'labels' => $labels,
            'costValues' => $costValues,
            'totalCost' => $totalCost,
            'tripsData' => $tripsData,
            'fuelsData' =>  $fuelsData
        ]);
    }
    public function logbook(){
        $vehicles = Vehicle::with('vehicleType')
            ->withSum('fuels', 'quantity')
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
