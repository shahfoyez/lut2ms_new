<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Routex;
use App\Models\Vehicle;
use App\Models\Employee;
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
        $vehicles = Vehicle::latest()
            ->with(['activeTrip' => function ($query) {
                $query->where('status', 0);
            }])
            ->with('vehicleType:id,name')
            ->withCount('trips')
            ->get();

        // dd($vehicles);
        return view('reqVehicles', [
            'lists' => $vehicles,
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
        return view('vehicleSend', [
            'vehicle' => $vehicle,
            'routes' => $routes,
            'drivers' => $drivers
        ]);
    }
    public function vehicleSend()
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

        $vehicle = Vehicle::where('id', $trip->vid)->update([
            'status' => 'trip'
        ]);

        return redirect('/requisition/vehicles')->with('success', 'Trip has been send');
    }
    public function vehicleReach($vid)
    {
        $vehicle = Vehicle::where('id', $vid)->first();
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
        }else{
            abort(404, 'Invalid Action!');
            // return back()->with('error', 'Oops! Something went wrong!');
        }
        return back()->with('success', 'Trip status has been changed');
    }

    public function vehicleCancel($vid)
    {
        $vehicle = Vehicle::where('id', $vid)->first();
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
        $vehicle = Vehicle::where('id', $vehicle)->first();
        return view('vehicleTrips',[
            'trips' => $trips,
            'vehicle' => $vehicle
        ]);
    }

    public function filter()
    {
        // dd(request()->all());
        $query = Vehicle::query();
        if(request()->input('status')){
            $vehicles = $query->where('status', request()->input('status'))
            ->with(['activeTrip' => function ($query) {
                $query->where('status', 0);
            }])
            ->with('vehicleType:id,name')
            ->withCount('trips')
            ->get();
        }
        return view('reqVehicles', [
            'lists' => $vehicles
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
