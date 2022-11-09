<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fuel;
use App\Models\Meter;
use App\Models\Vehicle;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;

class MaintenanceController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::withCount('maintenanceEntries')
            ->withSum('maintenanceEntries', 'cost')
            ->withMax('maintenanceEntries', 'from')
            ->get();
        return view('maintenanceVehicles', [
            'vehicles' => $vehicles
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        $vehicles = Vehicle::get();
        return view('maintenanceAdd', [
            'vehicles' => $vehicles,
            'selVehicle' => $vehicle
        ]);
    }
    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        $from = $request->input('from');
        $from = Carbon::createFromFormat('Y-m-d\TH:i', $from)->format('Y-m-d H:i A');

        $attributes= $request->validate([
            'vid'=> 'required',
            'cost'=>  'required|integer',
            'from' => 'required|date',
            'to'=> 'nullable|date|after:from',
            'note'=> 'nullable'
        ]);
        $create= Maintenance::create([
            'vid'=> $request->input('vid'),
            'cost'=> $request->input('cost'),
            'from'=> $request->input('from'),
            'to'=> $request->input('to'),
            'note' => $request->input('note'),
            'added_by' => $added_by
        ]);
        return redirect('/maintenance/maintenanceVehicles')->with('success', 'Maintenance entry has been added');
    }


    public function show()
    {
        $maintenanceRecords = Maintenance::latest('from')->with('vehicle')->get();
        return view('maintenanceRecords', [
                'maintenanceRecords' => $maintenanceRecords
        ]);
    }
    public function  vehicleMaintenanceEntries($vehicle)
    {
        $maintenanceRecords = Maintenance::latest('from')->where('vid', $vehicle)->get();
        $vehicle = Vehicle::find($vehicle)->codeName;
        // dd( $vehicle);
        // dd($maintenanceRecords);
        return view('vehicleMaintenanceRecords', [
                'maintenanceRecords' => $maintenanceRecords,
                'vehicle' => $vehicle
        ]);
    }


    public function edit($maintenance)
    {
        $maintenance = Maintenance::with('vehicle')->find($maintenance);
        // dd($maintenance);
        return view('maintenanceEdit', [
            'maintenance' => $maintenance
        ]);
    }

    public function update($maintenance, Request $request)
    {
        $from = $request->input('from');
        $from = Carbon::createFromFormat('Y-m-d\TH:i', $from)->format('Y-m-d H:i A');
        $attributes= $request->validate([
            'vid'=> 'prohibited',
            'cost'=>  'required|integer',
            'from' => 'required|date',
            'to'=> 'nullable|date|after:from',
            'note'=> 'nullable'
        ]);
        $create= Maintenance::where('id', $maintenance)
        ->update([
            'cost'=> $request->input('cost'),
            'from'=> $request->input('from'),
            'to'=> $request->input('to'),
            'note' => $request->input('note')
        ]);
        return redirect('/maintenance/maintenanceVehicles')->with('success', 'Maintenance entry has been updated.');
    }

    public function destroy($maintenance)
    {
        $data = Maintenance::find($maintenance);
        if($data){
            $data->delete();
            return back()->with('success', 'Maintenance  Record has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
