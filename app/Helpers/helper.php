<?php
use Carbon\Carbon;
use App\Models\Fuel;
use App\Models\Trip;
use App\Models\Maintenance;

function fuelsData(){
    date_default_timezone_set('Asia/Dhaka');
    $currentMonthYear = Carbon::now()->format('F-Y');
    $previousMonthYear = Carbon::now()->subMonth()->format('F-Y');

    // mapping to check current month and previous month data
    $fuels = Fuel::selectRaw("date_format(`date`, '%M-%Y') As monthYear, year(`date`) AS year, month(`date`) AS month, count(id) as fuelEntries, sum(quantity) AS totalFuels, sum(cost) AS totalCosts")
        ->groupByRaw("monthYear")
        ->groupByRaw("year")
        ->groupByRaw("month")
        ->orderBy('year', "DESC")
        ->orderBy('month', "DESC")
        ->take(12)
        ->get()
        ->map(function($fuel) use ($currentMonthYear, $previousMonthYear) {
            if ($fuel->monthYear == $currentMonthYear) {
                $fuel->status = 1;
            } elseif ($fuel->monthYear == $previousMonthYear) {
                $fuel->status = 2;
            } else {
                $fuel->status = 0;
            }
            return $fuel;
        });
    $fuels_labels = array();
    $fuels_count_values = array();
    $fuels_cost_values = array();

    $total_fuels = 0;
    $avg_fuels = 0;
    // fuel quantity
    $cur_month_fuels = 0;
    $last_month_fuels = 0;

    $c1_Date = Carbon::parse($currentMonthYear);
    $fuel_cur_month =  $c1_Date->format('F');

    $c2_Date = Carbon::parse($previousMonthYear);
    $fuel_last_month = $c2_Date->format('F');

    if($fuels->count() > 0){
        foreach($fuels as $fuel){
            // status 1 indicates current month & status 2 indicates previous month
            if($fuel->status === 1){
                $cur_month_fuels = $fuel->totalFuels;
                $curCarbonDate = Carbon::parse($fuel->monthYear);
                $fuel_cur_month = $curCarbonDate->format('F');
            }elseif($fuel->status === 2){
                $last_month_fuels = $fuel->totalFuels;
                $lastCarbonDate = Carbon::parse($fuel->monthYear);
                $fuel_last_month = $lastCarbonDate->format('F');
            }
            $curCarbonDate = Carbon::parse($fuel->monthYear);
            $fuel_label = $curCarbonDate->format('M y');
            $total_fuels += $fuel->totalFuels;

            array_push($fuels_labels, $fuel_label);
            array_push($fuels_count_values, $fuel->totalFuels);
            array_push( $fuels_cost_values, $fuel->totalCosts);
        }
        $avg_fuels = number_format($total_fuels/sizeof($fuels_labels), 2);
    }
    $fuelsData = array(
        'fuels_labels' => $fuels_labels,
        'fuels_count_values' => $fuels_count_values,
        'fuels_cost_values' => $fuels_cost_values,
        'total_fuels' => $total_fuels,
        'avg_fuels' =>  $avg_fuels,
        'cur_month_fuels' => $cur_month_fuels,
        'last_month_fuels' => $last_month_fuels,
        'fuel_cur_month' => $fuel_cur_month,
        'fuel_last_month' => $fuel_last_month
    );
    // dd($fuelsData);
    return $fuelsData;
}
function tripsData(){
    date_default_timezone_set('Asia/Dhaka');
    $currentMonthYear = Carbon::now()->format('F-Y');
    $previousMonthYear = Carbon::now()->subMonth()->format('F-Y');

    $trips = Trip::selectRaw("DATE_FORMAT(`start`, '%M-%Y') as monthYear, year(`start`) AS year, month(`start`) AS month, count(id) AS totalTrips")
        ->where('status', 1)
        ->groupByRaw("monthYear")
        ->groupByRaw("year")
        ->groupByRaw("month")
        ->orderBy('year', "DESC")
        ->orderBy('month', "DESC")
        ->take(12)
        ->get()
        ->map(function($trip) use ($currentMonthYear, $previousMonthYear) {
            if ($trip->monthYear == $currentMonthYear) {
                $trip->status = 1;
            } elseif ($trip->monthYear == $previousMonthYear) {
                $trip->status = 2;
            } else {
                $trip->status = 0;
            }
            return $trip;
        });
        // dd($trips);
    $trips_labels = array();
    $trips_count_values = array();
    $total_trips = 0;
    $avg_trips = 0;
    $cur_month_trips = 0;
    $last_month_trips = 0;

    $c1_Date = Carbon::parse($currentMonthYear);
    $trip_cur_month =  $c1_Date->format('F');

    $c2_Date = Carbon::parse($previousMonthYear);
    $trip_last_month = $c2_Date->format('F');

    if($trips->count() > 0){
        foreach($trips as $trip){
            // status 1 indicates current month & status 2 indicates previous month
            if($trip->status === 1){
                $cur_month_trips = $trip->totalTrips;
                $curCarbonDate = Carbon::parse($trip->monthYear);
                $trip_cur_month = $curCarbonDate->format('F');
            }elseif($trip->status === 2){
                $last_month_trips = $trip->totalTrips;
                $lastCarbonDate = Carbon::parse($trip->monthYear);
                $trip_last_month = $lastCarbonDate->format('F');
            }
            $curCarbonDate = Carbon::parse($trip->monthYear);

            $trip_label = $curCarbonDate->format('M y');
            $total_trips += $trip->totalTrips;
            array_push($trips_labels, $trip_label);
            array_push($trips_count_values, $trip->totalTrips);
        }
        $trip_avg = $total_trips/sizeof($trips_labels);
        $avg_trips = is_float($trip_avg) ? number_format($trip_avg, 2) : $trip_avg;

    }
    $tripsData = array(
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
function maintenanceData(){
    date_default_timezone_set('Asia/Dhaka');
    $currentMonthYear = Carbon::now()->format('F-Y');
    $previousMonthYear = Carbon::now()->subMonth()->format('F-Y');
    $maintenanceStats = Maintenance::selectRaw("date_format(`from`, '%M-%Y') As monthYear, year(`from`) AS year, month(`from`) AS month, sum(cost) AS totalCost")
    ->groupByRaw("monthYear")
    ->groupByRaw("year")
    ->groupByRaw("month")
    ->orderBy('year', "DESC")
    ->orderBy('month', "DESC")
    ->take(12)
    ->get()
    ->map(function($fuel) use ($currentMonthYear, $previousMonthYear) {
        if ($fuel->monthYear == $currentMonthYear) {
            $fuel->status = 1;
        } elseif ($fuel->monthYear == $previousMonthYear) {
            $fuel->status = 2;
        } else {
            $fuel->status = 0;
        }
        return $fuel;
    });
    // dd($maintenanceStats);

    $labels = array();
    $costValues = array();
    $totalCost = 0;
    $avgCost = 0;
    $curCost = 0;
    $lastCost = 0;

    $c1_Date = Carbon::parse($currentMonthYear);
    $thisMonth =  $c1_Date->format('F');

    $c2_Date = Carbon::parse($previousMonthYear);
    $lastMonth = $c2_Date->format('F');

    if($maintenanceStats->count() > 0){
        foreach($maintenanceStats as $stat){
             // status 1 indicates current month & status 2 indicates previous month
             if($stat->status === 1){
                $curCost = $stat->totalCost;
                $curCarbonDate = Carbon::parse($stat->monthYear);
                $thisMonth = $curCarbonDate->format('F');
            }elseif($stat->status === 2){
                $lastCost = $stat->totalCost;
                $lastCarbonDate = Carbon::parse($stat->monthYear);
                $lastMonth = $lastCarbonDate->format('F');
            }
            $curCarbonDate = Carbon::parse($stat->monthYear);
            $label = $curCarbonDate->format('M y');
            $totalCost += $stat->totalCost;
            array_push($labels, $label);
            array_push($costValues, $stat->totalCost);
        }
        $avgCost = $totalCost/sizeof($labels);
    }
    $maintenanceData = array(
        'labels' => $labels,
        'costValues' => $costValues,
        'totalCost' => (int)$totalCost,
        'avgCost' =>  (int)$avgCost,
        'curCost' => $curCost,
        'lastCost' => $lastCost,
        'thisMonth' => $thisMonth,
        'lastMonth' => $lastMonth
    );
    return $maintenanceData;
}
