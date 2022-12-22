<?php

use Carbon\Carbon;
use App\Models\Fuel;
use App\Models\Trip;
use App\Models\Maintenance;
function tripsData(){
    $trips = Trip::selectRaw("DATE_FORMAT(`start`, '%M-%y') as monthYear, year(`start`) AS year, month(`start`) AS month, monthname(`start`) AS monthName, count(id) AS totalTrips")
        ->where('status', 1)
        ->groupByRaw("monthName")
        ->groupByRaw("monthYear")
        ->groupByRaw("year")
        ->groupByRaw("month")
        ->orderBy('year', "DESC")
        ->orderBy('month', "DESC")
        ->get()->take(12);

    $trips_labels = array();
    $trips_count_values = array();
    $total_trips = 0;
    $avg_trips = 0;
    $cur_month_trips = 0;
    $last_month_trips = 0;
    // for use in loop
    $cur_month_trip_found = 0;

    $curYear = date("Y");
    $curMonth = date("m");
    $trip_cur_month = '';
    $trip_last_month = '';

    if($trips->count() > 0){
        foreach($trips as $trip){
            if($curMonth == $trip->month && $curYear == $trip->year){
                // calculate current month's trip and month name
                $cur_month_trips = $trip->totalTrips;
                $trip_cur_month = $trip->monthName;
                $cur_month_trip_found = 1;
            }elseif($cur_month_trip_found == 1){
                $last_month_trips = $trip->totalTrips;
                $cur_month_trip_found = 2;
                $trip_last_month = $trip->monthName;
            }
            $year = substr($trip->year, -2);
            $month = $trip->monthName;
            $trip_label = $month." ".$year;
            $total_trips += $trip->totalTrips;
            array_push($trips_labels, $trip_label);
            array_push($trips_count_values, $trip->totalTrips);
        }
        $avg_trips = $total_trips/sizeof($trips_labels);
    }
    $tripsData = array(
        'f' => $trips,
        'trips_labels' => $trips_labels,
        'trips_count_values' => $trips_count_values,
        'total_trips' => $total_trips,
        'avg_trips' =>  $avg_trips,
        'cur_month_trips' => $cur_month_trips,
        'last_month_trips' => $last_month_trips,
        'trip_cur_month' => $trip_cur_month,
        'trip_last_month' => $trip_last_month
    );
    return $tripsData;
}
function fuelsData(){
    $fuels = Fuel::selectRaw("date_format(`date`, '%M-%y') As monthYear, year(`date`) AS year, month(`date`) AS month, monthname(`date`) AS monthName, count(id) as fuelEntries, sum(quantity) AS totalFuels, sum(cost) AS totalCosts")
        ->groupByRaw("monthName")
        ->groupByRaw("monthYear")
        ->groupByRaw("year")
        ->groupByRaw("month")
        ->orderBy('year', "DESC")
        ->orderBy('month', "DESC")
        ->get()->take(12);
    // dd($fuels);
    $fuels_labels = array();
    $fuels_count_values = array();
    $total_fuels = 0;
    $avg_fuels = 0;
    $cur_month_fuels = 0;
    $last_month_fuels = 0;
    // for use in loop
    $cur_month_fuel_found = 0;

    $curYear = date("Y");
    $curMonth = date("m");
    $fuel_cur_month = '';
    $fuel_last_month = '';

    if($fuels->count() > 0){
        foreach($fuels as $fuel){
            if($curMonth == $fuel->month && $curYear == $fuel->year){
                // calculate current month's trip and month name
                $cur_month_fuels = $fuel->totalFuels;
                $fuel_cur_month = $fuel->monthName;
                $cur_month_fuel_found = 1;
            }elseif($cur_month_fuel_found == 1){
                $last_month_fuels = $fuel->totalFuels;
                $cur_month_fuel_found = 0;
                $fuel_last_month = $fuel->monthName;
            }
            $year = substr($fuel->year, -2);
            $month = $fuel->monthName;
            $fuel_label = $month." ".$year;
            $total_fuels += $fuel->totalFuels;
            array_push($fuels_labels, $fuel_label);
            array_push($fuels_count_values, $fuel->totalFuels);
        }
        $avg_fuels = $total_fuels/sizeof($fuels_labels);
    }
    $tripsData = array(
        'fuels_labels' => $fuels_labels,
        'fuels_count_values' => $fuels_count_values,
        'total_fuels' => $total_fuels,
        'avg_fuels' =>  $avg_fuels,
        'cur_month_fuels' => $cur_month_fuels,
        'last_month_fuels' => $last_month_fuels,
        'fuel_cur_month' => $fuel_cur_month,
        'fuel_last_month' => $fuel_last_month
    );
    // dd($tripsData);
    return $tripsData;

}

//function maintenanceData(){
    //     $maintenanceStats = Maintenance::selectRaw("year(`from`) AS year, month(`from`) AS month, monthname(`from`) AS monthName, sum(cost) AS totalCost")
    //         ->groupByRaw("monthName(`from`)")
    //         ->groupByRaw("year(`from`)")
    //         ->groupByRaw("month(`from`)")
    //         ->orderBy('year', "DESC")
    //         ->orderBy('month', "DESC")
    //         ->get()->take(12);
    //     // variables
    //     $labels = array();
    //     $costValues = array();
    //     $totalCost = 0;
    //     $avgCost = 0;
    //     $curCost = 0;
    //     $lastCost = 0;
    //     $curFound = 0;
    //     $curYear = date("Y");
    //     $curMonth = date("m");

    //     $lastMonth = '';
    //     $thisMonth = '';

    //     if($maintenanceStats->count() > 0){
    //         foreach($maintenanceStats as $stats){
    //             if($curMonth == $stats->month && $curYear == $stats->year){
    //                 $curCost = $stats->totalCost;
    //                 $thisMonth = $stats->monthName;
    //                 $curFound = 1;
    //             }elseif($curFound == 1){
    //                 $lastCost = $stats->totalCost;
    //                 $curFound = 2;
    //                 $lastMonth = $stats->monthName;
    //             }
    //             $year = substr($stats->year, -2);
    //             $month = $stats->monthName;
    //             $label = $month." ".$year;
    //             $totalCost += $stats->totalCost;
    //             array_push($labels, $label);
    //             array_push($costValues, $stats->totalCost);
    //         }
    //         $avgCost = $totalCost/sizeof($labels);
    //     }
    //     $maintenanceData = array(
    //         'maintenanceStats' => $maintenanceStats,
    //         'totalCost' => (int)$totalCost,
    //         'avgCost' =>  (int)$avgCost,
    //         'curCost' => $curCost,
    //         'lastCost' => $lastCost,
    //         'thisMonth' => $thisMonth,
    //         'lastMonth' => $lastMonth
    //     );
    //     return $maintenanceData;
    // }
