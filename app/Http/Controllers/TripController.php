<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Routex;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Stoppage;
use App\Models\OnTripVehicle;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;

class TripController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
    public function store()
    {
        //
    }

    public function reqVehicles()
    {
        $vehicles = Vehicle::with(['activeTrip' => function ($query) {
                $query->where('status', 0);
            }])
            ->with('vehicleType:id,name')
            ->withCount('trips')
            ->latest()->get();

        // dd($vehicles);
        return view('reqVehicles', [
            'lists' => $vehicles
        ]);
    }
    public function show()
    {
        $trips = Trip::where('status', '!=', 0)
            ->with('vehicle', 'rout', 'employee')
            ->latest()
            ->get();
        // dd($trips);
        return view('tripHistory', [
                'trips' => $trips
        ]);
    }

    public function edit($trip)
    {
        // dd($trip);
        $trip = Trip::with('vehicle:id,id')->find($trip);
        // dd($trip);
        $vehicles = Vehicle::with('vehicleType:id,name')->latest()->get();

        $routes = Routex::get();
        $drivers = Employee::get()->where('designation', 1);
        return view('tripEdit', [
            'trip' => $trip,
            'routes' => $routes,
            'drivers' => $drivers
        ]);
    }

    public function vehicleCreate($vehicle)
    {
        $vehicle = Vehicle::with('vehicleType:id,name')->find($vehicle);
        $routes = Routex::get();
        $drivers = Employee::get()->where('designation', 1);
        $stoppages = Stoppage::latest()->get();
        return view('vehicleSend', [
            'vehicle' => $vehicle,
            'routes' => $routes,
            'drivers' => $drivers,
            'stoppages' => $stoppages
        ]);
    }
    public function vehicleSend()
    {
        // dd(request()->input('show_map'));
        $start = request()->input('start');
        $attributes=request()->validate([
            'vid'=> 'required',
            'route'=>  'required|integer',
            'start'=> 'required|date',
            'end'=> 'required|date|after:'.$start,
            'from'=> 'required|string',
            'dest'=> 'required|string',
            'driver'=> 'required'
        ]);
        $trip= Trip::create([
            'vid'=> request()->input('vid'),
            'route'=> request()->input('route'),
            'start'=> request()->input('start'),
            'end' =>  request()->input('end'),
            'from'=> request()->input('from'),
            'dest'=> request()->input('dest'),
            'driver' =>request()->input('driver'),
            'status' => 0
        ]);

        if($trip){
            $OnTripVehicle= OnTripVehicle::create([
                'trip_id'=> $trip->id,
                'vid'=> request()->input('vid'),
                'route'=> request()->input('route'),
                'show_map' => request()->input('show_map')
            ]);
            $vehicle = Vehicle::where('id', $trip->vid)->update([
                'status' => 'trip'
            ]);
            $driver = Employee::where('id', $trip->driver)
            ->Where('status', 0)
            ->update([
                'status' => 1
            ]);
        }

        return redirect('/requisition/vehicles')->with('success', 'Trip has been send');
    }
    public function vehicleReach($vid)
    {
        $vehicle = Vehicle::find($vid);
        $trip = Trip::orderBy('created_at', 'desc')->where('vid', $vid)->first();
        if($vehicle && $trip){
            $vehicleUpdate = Vehicle::where('id', $vid)->update([
                'status' => 'available'
            ]);
            $end = date('Y/m/d H:i:s');
            $tripUpdate = Trip::where('id', $trip->id)->update([
                'end' => $end,
                'status' => 1
            ]);
            $driverStatus = Employee::where('id', $trip->driver)->update([
                'status' => 0
            ]);
            $OnTripVehicle = OnTripVehicle::where('trip_id', '=', $trip->id)
                ->where('vid', '=', $vid)
                ->delete();
        }else{
            abort(404, 'Invalid Action!');
            // return back()->with('error', 'Oops! Something went wrong!');
        }
        return back()->with('success', 'Trip status has been changed');
    }

    public function vehicleCancel($vid)
    {
        $vehicle = Vehicle::find($vid);
        $trip = Trip::orderBy('created_at', 'desc')->where('vid', $vid)->first();
        if($vehicle && $trip){
            $vehicleUpdate = Vehicle::where('id', $vid)->update([
                'status' => 'available'
            ]);
            $end = date('Y/m/d H:i:s');
            $tripUpdate = Trip::where('id', $trip->id)->update([
                'end' => $end,
                'status' => 2
            ]);
            $driverStatus = Employee::where('id', $trip->driver)->update([
                'status' => 0
            ]);
            $OnTripVehicle = OnTripVehicle::where('trip_id', '=', $trip->id)
                ->where('vid', '=', $vid)
                ->delete();
        }else{
            abort(404, 'Invalid Action!');
            // return back()->with('error', 'Oops! Something went wrong!');
        }
        return back()->with('success', 'Trip has been canceled!');
    }

    public function update($trip)
    {
        $start = request()->input('start');
        $attributes=request()->validate([
            'vid'=> 'required',
            'route'=>  'required|integer',
            'start'=> 'required|date',
            'end'=> 'required|date|after:'.$start,
            'from'=> 'required|string',
            'dest'=> 'required|string',
            'driver'=> 'required'
        ]);
        $update = Trip::where('id', $trip)
            ->update([
                'route'=> request()->input('route'),
                'start'=> request()->input('start'),
                'end' =>  request()->input('end'),
                'from'=> request()->input('from'),
                'dest'=> request()->input('dest'),
                'driver' =>request()->input('driver'),
                'status' => 0
        ]);
        return redirect('/requisition/vehicles')->with('success', 'Requisition information updated.');
    }

    public function vehicleTrips($vehicle){
        $trips = Trip::latest()
            ->where('vid', $vehicle)
            ->where('status', '!=', 0)
            ->get();
        $vehicle = Vehicle::find($vehicle);
        return view('vehicleTrips',[
            'trips' => $trips,
            'vehicle' => $vehicle
        ]);
    }

    public function filter()
    {
        // dd(request()->all());
        $query = Vehicle::query();
        $status = request()->input('status');
        if(request()->input('status')){
            $vehicles = $query->where('status', $status)
            ->with(['activeTrip' => function ($query) {
                $query->where('status', 0);
            }])
            ->with('vehicleType:id,name')
            ->withCount('trips')
            ->get();
        }
        return view('reqVehicles', [
            'lists' => $vehicles,
            'filter' =>  $status
        ]);
    }

    public function tripFilter()
    {
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Trip::query();
        if(request()->input('date')){
            $trips = $query->whereBetween('start', [$start, $end])
                ->where('status', '!=', 0)
                ->with('vehicle', 'rout', 'employee')
                ->latest()
                ->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        // dd($trips);
        return view('tripHistory', [
            'trips' => $trips,
            'start' => $start,
            'end' => $end
        ]);
    }


    public function vehicleTripsFilter($vehicle)
    {
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Trip::query();
        if(request()->input('date')){
            $trips = Trip::latest()
                ->whereBetween('start', [$start, $end])
                ->where('vid', $vehicle)
                ->where('status', '!=', 0)
                ->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');

        $vehicle = Vehicle::find($vehicle);
        return view('vehicleTrips',[
            'trips' => $trips,
            'vehicle' => $vehicle,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function destroy($trip)
    {
        $data = Trip::find($trip);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Trip has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
