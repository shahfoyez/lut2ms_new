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
                'max:10',
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

    public function edit(GpsDevice $gpsDevice)
    {
        $gpsDevice = $gpsDevice->load(['vehicle' => function($query){
            $query->select('id', 'codeName');
        }]);
        // $gpsDevice = GpsDevice::with(['vehicle' => function($query){
        //     $query->select('id', 'codeName');
        // }])->findOrFail($gpsDevice->id);

        $vehicles = Vehicle::with(['gpsDevice' => function($query){
            $query->select('id', 'code_name', 'vid')->get();
        }])->latest()->get();
        // dd( $vehicles);
        return view('deviceEdit', [
            'gpsDevice' => $gpsDevice,
            'vehicles' => $vehicles
        ]);
    }
    public function update(GpsDevice $gpsDevice)
    {
        $attributes = request()->validate([
            'code_name'=> [
                'required',
                Rule::unique('gps_devices', 'code_name')->ignore($gpsDevice->code_name, 'code_name'),
                'min:3',
                'max:10',
            ],
            'vid'=>  [
                'nullable',
                Rule::unique('gps_devices', 'vid')->ignore($gpsDevice->vid, 'vid'),
            ]
        ]);
        $vid = request()->input('vid') == 0 ? null : request()->input('vid');

        $gpsUpdate = $gpsDevice->update([
            'code_name'=> request()->input('code_name'),
            'vid'=> $vid,
        ]);
        if($gpsUpdate){
            return redirect('/vehicle/devices')->with('success', 'Gps information updated.');
        }else{
            return back('/vehicle/devices')->with('erroe', 'Sorry! Something went wrong.');
        }
    }
    public function destroy($device)
    {
        $data = GpsDevice::findOrFail($device);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Gps Device has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
