<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Routex;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\GpsDevice;
use App\Models\VehicleType;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;

class VehicleController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $vehicles = Vehicle::with('vehicleType:id,name')->latest()->get();
        // dd($vehicles);
        return view('vehicles', [
            'lists' => $vehicles,
        ]);
    }
    public function vehicleAdd()
    {
        $types = VehicleType::latest()->get();
        $types = VehicleType::latest()->get();

        $devices = GpsDevice::latest()->with('vehicle')->get();
        dd($devices);
        return view('vehicleAdd', [
            'devices' => $devices,
            'types' => $types
        ]);
    }

    public function store()
    {
        // dd(request()->all());
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'codeName'=> [
                'required',
                Rule::unique('vehicles', 'codeName'),
                'min:3',
                'max:255'
            ],
            'license'=>  'nullable||string',
            'capacity'=> 'nullable||numeric',
            'meter_start' => 'required||numeric',
            'type'=> 'required',
            'status'=> 'required',
            'gps_id'=> ['nullable', Rule::unique('vehicles', 'gps_id')],
            'image' => 'max:150'
        ]);

        if (request()->has('image')) {
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/vehicle'),$imageName);
            $imageName = "assets/uploads/vehicle/".$imageName;
        }else{
            $imageName = "";
        }
        $employee= Vehicle::create([
            'codeName'=> request()->input('codeName'),
            'license'=> request()->input('license'),
            'capacity'=> request()->input('capacity'),
            'meter_start'=> request()->input('meter_start'),
            'image' => $imageName,
            'type'=> request()->input('type'),
            'status'=> request()->input('status'),
            'gps_id'=> request()->input('gps_id'),
            'added_by' => $added_by
        ]);
        return redirect("/vehicle/vehicles")->with('success', 'Vehicle has been added');
    }

    public function show(Vehicle $vehicle)
    {
        //
    }
    public function edit(Vehicle $vehicle)
    {
        // $vehicles = Vehicle::with('user:id,name,added_by')->find($vehicle->id); //added_by for Nested Eager Loading, id is necessary
        $types = VehicleType::latest()->withCount('vehicles')->get();
        $vehicle = Vehicle::with('user:id,name')->find($vehicle->id);
        return view('vehicleEdit', [
            'vehicle' => $vehicle,
            'types' => $types
        ]);
    }

    public function update(Vehicle $vehicle)
    {
        // dd(public_path($vehicle->image));
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'codeName'=> [
                'required',
                Rule::unique('vehicles', 'codeName')->ignore($vehicle->codeName, 'codeName'),
                'min:3',
                'max:255'
            ],
            'license'=>  'required',
            'capacity'=> 'required|numeric',
            'meter_start' => 'required|numeric',
            'image' => 'max:150'
        ]);

        if (request()->has('image')) {
            if ($vehicle->image) {
                unlink(public_path($vehicle->image));
            }
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/vehicle'),$imageName);
            $imageName = "assets/uploads/vehicle/".$imageName;
        }else{
            $imageName =  $vehicle->image;
        }
        $update= $vehicle->update([
            'codeName'=> request()->input('codeName'),
            'license'=> request()->input('license'),
            'capacity'=> request()->input('capacity'),
            'meter_start'=> request()->input('meter_start'),
            'image' => $imageName,
            'type'=> request()->input('type'),
            'status'=> request()->input('status'),
            'added_by' => $added_by
        ]);
        return redirect('/vehicle/vehicles')->with('success', 'Vehicle information updated.');
    }

    public function destroy($stoppage)
    {
        $data = Vehicle::find($stoppage);
        if($data){
            if($data->image){
                unlink(public_path($data->image));
            }
            $data->delete();
            return back()->with('success', 'Stoppage has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }


    public function typeAdd(){
        return view('vehicleTypeAdd');
    }
    public function typeStore(){
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255'
        ]);
        $create= VehicleType::create([
            'name'=> request()->input('name'),
            'added_by' => $added_by
        ]);
        return redirect('/vehicle/vehicleTypes')->with('success', 'Vehicle type has been added');
    }
    public function vehicleTypes()
    {
        $types = VehicleType::latest()->withCount('vehicles')->get();
        return view('vehicleTypes', [
            'types' => $types
        ]);
    }

    public function typeEdit(VehicleType $type)
    {
        return view('vehicleTypeEdit', [
            'type' => $type,
        ]);
    }

    public function typeUpdate(VehicleType $type)
    {
         // dd(request()->all());
         $added_by= auth()->user()->id;
         $attributes=request()->validate([
             'name'=> 'required | min:3 | max:255',
         ]);
         $update = $type->update([
                'name'=> request()->input('name')
             ]);
         return redirect('/vehicle/vehicleTypes')->with('success', 'Department information updated.');
    }

    public function typeDestroy($type)
    {
        $data = VehicleType::find($type);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Route has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function filter()
    {
        // dd(request()->all());
        $status = request()->input('status');
        if($status){
            $vehicles = Vehicle::where('status',  $status)
                ->with('vehicleType:id,name')
                ->latest()->get();
        }
        return view('vehicles', [
            'lists' => $vehicles,
            'filter' =>  $status
        ]);
    }
}
