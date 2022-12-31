<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Routex;
use App\Models\OnTripVehicle;
use App\Models\VehicleLocation;
use App\Http\Requests\StoreVehicleLocationRequest;
use App\Http\Requests\UpdateVehicleLocationRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Routex::with('stoppages')->orderBy('route', 'ASC')->get();
    }
    public function routeVehicles($route)
    {
        $trips = Trip::with([
            'vehicle',
            'vehicle.location',
            'vehicle.activeTrip' => function ($query) {
                $query->with('driver')->where('status', 0);
            }])
            ->with('employee')
            ->where('route', $route)
            ->where('status', 0)
            ->latest()->get()->pluck('vehicle');
        if($trips->count() > 0) {
            return response()->json($trips);
        } else {
            throw new HttpResponseException(response()->json([
                'success'   => false,
            ]));
        }
    }

    // public function tripVehicles()
    // {
    //     $trips = Trip::with(['vehicle', 'vehicle.location', 'vehicle.activeTrip' => function ($query) {
    //             $query->with('driver')->where('status', 0);
    //         }])
    //         ->with('employee')
    //         ->where('status', 0)
    //         ->latest()->get()->pluck('vehicle');
    //     return $trips;
    // }

    public function vehiclesLocation()
    {

        // $trips = OnTripVehicle::with([
        //     'vehicle' => function ($query) {
        //         $query->select('id', 'codename', 'license', 'capacity');
        //     },
        //     'vehicle.location' => function ($query) {
        //         $query->select('id', 'vid', 'long', 'lat', 'date');
        //     },
        //     'vehicle.activeTrip' => function ($query) {
        //         $query->with('rout')->with(['driver'  => function ($query) {
        //             $query->select('id', 'name', 'idNumber', 'phone', 'image');
        //         }])->where('status', 0);
        //     }])
        //     ->where('show_map', 1)
        //     ->latest()->get()->pluck('vehicle');

        // $withLocationShow = $trips->filter(function ($item) {
        //     return $item['location'] !== null ;
        // });
        // $withLocationHide = $trips->filter(function ($item) {
        //     return $item['location'] !== null && $item['show_map'] === 0;
        // });
        // $withoutLocation = $trips->filter(function ($item) {
        //     return $item['location'] === null;
        // });
        // return $withLocationShow;

        $trips = OnTripVehicle::with([
                'vehicle',
                'vehicle.location',
            ])
            ->with(['trip.driver'])
            ->with('rout')
            ->latest()->get();

        // return $trips;
        $withLocationShow = $trips->filter(function ($item) {
            return $item['vehicle']->location !== null && $item['show_map'] === 1;
        });
        $withLocationHide = $trips->filter(function ($item) {
            return $item['vehicle']->location && $item['show_map'] === 0;
        });
        $withoutLocation = $trips->filter(function ($item) {
            return $item['vehicle']->location === null;
        });
        $data = array([
            'withLocationShow' => $withLocationShow,
            'withLocationHide' => $withLocationHide,
            'withoutLocation' => $withoutLocation,
        ]);

        // without pluck(works), need to change view if implimented
        // $trips = OnTripVehicle::with([
        //         'vehicle' => function ($query) {
        //             $query->select('id', 'codename', 'license', 'capacity');
        //         },
        //         'vehicle.location' => function ($query) {
        //             $query->select('id', 'vid', 'long', 'lat', 'date');
        //         }

        //     ])
        //     ->with(['trip' => function($query){
        //         $query->with(['driver'  => function ($query) {
        //             $query->select('id', 'name', 'idNumber', 'phone', 'image');
        //         }]);
        //     }])
        //     ->latest()->get(['id', 'vid', 'trip_id']);

        if($trips->count()>0) {
            return response()->json([
                'withLocationShow' => $withLocationShow,
                'withLocationHide' => $withLocationHide,
                'withoutLocation' => $withoutLocation,
            ]);
        } else {
            throw new HttpResponseException(response()->json([
                'error'   => true,
            ]));
        }
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

    public function store($vid, $long, $lat)
    {
        $date = date("Y-m-d H:i:s");
        try {
            $location = VehicleLocation::updateOrCreate(
                [
                    'vid' => $vid
                ],
                [
                    'vid' => $vid,
                    'long' => $long,
                    'lat' => $lat,
                    'date' => $date,
                    'status' => 1
                ]
            );

            $content = array(
                'success' => true,
                'data' => $location,
                'message' => trans('Location Updated successfully')
            );
            return response($content)->setStatusCode(200);
        } catch (\Exception $e) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'There was an error while processing your request: ' .
                    $e->getMessage()
            );
            return response($content)->setStatusCode(500);
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
