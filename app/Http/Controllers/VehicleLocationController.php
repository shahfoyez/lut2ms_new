<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Routex;
use App\Models\VehicleLocation;
use App\Http\Requests\StoreVehicleLocationRequest;
use App\Http\Requests\UpdateVehicleLocationRequest;

class VehicleLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Routex::latest()->with('stoppages')->get();
    }
    public function routeVehicles($route)
    {
        $trips = Trip::with(['vehicle', 'vehicle.location', 'vehicle.activeTrip' => function ($query) {
                $query->with('driver')->where('status', 0);
            }])
            ->with('employee')
            ->where('route', $route)
            ->where('status', 0)
            ->latest()->get()->pluck('vehicle');
            dd($trips);
        return $trips;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleLocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($vid, $long, $lat)
    {
        $date = date("Y-m-d H:i:s");
        // request()->validate([
        //     'vid' => 'required',
        //     'long' => 'required',
        //     'lat' => 'required',
        //     'status' => 'required'
        // ]);
        $location  = VehicleLocation::where('vid',  $vid)->first();

        if($location){
            VehicleLocation::where('vid',  $vid)
            ->update([
                'vid' => $vid,
                'long' => $long,
                'lat' => $lat,
                'date' =>  $date,
                'status' => 1
            ]);
        }else{
            VehicleLocation::create([
                'vid' => $vid,
                'long' => $long,
                'lat' => $lat,
                'date' => $date,
                'status' => 1
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleLocation  $vehicleLocation
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleLocation $vehicleLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleLocation  $vehicleLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleLocation $vehicleLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleLocationRequest  $request
     * @param  \App\Models\VehicleLocation  $vehicleLocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleLocationRequest $request, VehicleLocation $vehicleLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleLocation  $vehicleLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleLocation $vehicleLocation)
    {
        //
    }
}
