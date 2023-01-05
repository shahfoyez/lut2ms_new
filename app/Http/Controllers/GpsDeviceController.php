<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\GpsDevice;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreGpsDeviceRequest;
use App\Http\Requests\UpdateGpsDeviceRequest;

class GpsDeviceController extends Controller
{
    public function index()
    {
        $devices = GpsDevice::with('vehicle')->latest()->get();
        // dd($devices);
        return view('devices',[
            'devices' => $devices
        ]);
    }

    public function deviceCreate()
    {
        $vehicles = Vehicle::with('gpsDevice')->latest()->get();
        // dd($vehicles);
        return view('deviceAdd', [
            'vehicles' => $vehicles
        ]);
    }
    public function deviceAdd()
    {
        $attributes=request()->validate([
            'code_name'=> [
                'required',
                'min:3',
                'max:255',
                Rule::unique('gps_devices', 'code_name')
            ],
            'vid' => [
                'nullable',
                Rule::unique('gps_devices', 'vid')
            ]
        ]);
        $vid = request()->input('vid') == 0 ? null : request()->input('vid');

        $create= GpsDevice::create([
            'code_name'=> request()->input('code_name'),
            'vid'=>  $vid
        ]);
        return redirect('/vehicle/devices')->with('success', 'Router has been added');
    }
    public function destroy($device)
    {
        $data = GpsDevice::find($device);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Gps Device has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
