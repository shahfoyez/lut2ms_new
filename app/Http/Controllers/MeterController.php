<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Meter;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMeterRequest;
use App\Http\Requests\UpdateMeterRequest;

class MeterController extends Controller
{

    public function index()
    {
        $vehicles = Vehicle::withCount('meterEntries')
            ->withMax('meterEntries', 'date')
            ->withMax('meterEntries', 'meter_entry')
            ->withMin('meterEntries', 'meter_entry')
            ->get();
        return view('meterVehicles', [
            'vehicles' => $vehicles
        ]);
    }

    public function create($vehicle)
    {
        $selVehicle = Vehicle::withMax('meterEntries', 'meter_entry')
        ->withMax('meterEntries', 'date')
        ->findOrFail($vehicle);
        $vehicles = Vehicle::get();
        // dd($selVehicle);
        return view('meterEntryAdd', [
            'vehicles' => $vehicles,
            'selVehicle' => $selVehicle
        ]);
    }

    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        // Checks if there's any previous entry
        $entry = Meter::latest('date')->firstWhere('vid', $request->input('vid'));
        // Find initial meter reading
        $minEntry = Vehicle::Where('id', $request->input('vid'))->first(['meter_start'])->meter_start;
        $status = $request->input('status');
        if($entry){
            $newEntry = $request->input('date');
            $new = Carbon::createFromFormat('Y-m-d\TH:i', $newEntry)->format('Y-m-d H:i');
            $prev =  $entry->date->format('Y-m-d H:i');
            $prefix = $status == 2 ? "before" : "after";
            $mmPrefix = $status == 2 ? "max" : "min";
            $attributes= $request->validate([
                'vid'=> 'required',
                'meter_entry'=>  'numeric|'.$mmPrefix.':'.$entry->meter_entry,
                'date' => 'required|date|'.$prefix.':'.$prev,
                'status'=> 'required',
                'note'=> 'nullable'
            ],
            [
                'date.'.$prefix => 'Date should be '.$prefix." ".$prev,

            ]);

            if ($status == 1) {
                $update = $entry->update([
                    'status' => 0
                ]);
            }
        }else{
            $attributes= $request->validate([
                'vid'=> 'required',
                'meter_entry'=>  'numeric|min:'.$minEntry+1,
                'date' => 'required|date',
                'status'=> 'required',
                'note'=> 'nullable'
            ]);
        }
        $create= Meter::create([
            'vid'=> $request->input('vid'),
            'meter_entry'=> $request->input('meter_entry'),
            'date'=> $request->input('date'),
            'status'=> $request->input('status'),
            'note' => $request->input('note'),
            'added_by' => $added_by
        ]);
        return redirect('/meter/meterVehicles')->with('success', 'Meter reading has been added');
    }


    public function show()
    {
        $meterEntries = Meter::latest()->with('vehicle')->get();
        return view('meterEntries', [
                'meterEntries' => $meterEntries
        ]);
    }

    public function vehicleMeterEntries(Vehicle $vehicle)
    {
        $meterEntries = Meter::latest('date')->Where('vid', $vehicle->id)->get();
        return view('vehicleMeterEntries', [
            'meterEntries' => $meterEntries,
            'vehicle'=>  $vehicle
        ]);
        // dd($meterEntries);
    }
    public function edit($meter)
    {
        $meter = Meter::with('vehicle:id,id,codeName,meter_start')->findOrFail($meter);
        // dd($meter->vehicle);

        $min = Meter::where('vid', $meter->vid)
            ->where('meter_entry', '<', $meter->meter_entry)
            ->orderBy('meter_entry', 'DESC')
            ->first();
        $max = Meter::where('vid', $meter->vid)
            ->where('meter_entry', '>', $meter->meter_entry)
            ->orderBy('meter_entry', 'ASC')
            ->first();
        // $meter = $meter->push($min);
        // dd($meter);
        return view('meterEntryEdit', [
            'meter' => $meter,
            'min' => $min,
            'max' => $max
        ]);
    }

    public function update($meter)
    {
        $meter = Meter::with('vehicle:id,meter_start')->findOrFail($meter);
        // dd($meter);
        // dd(request()->all());
        $min = Meter::where('vid', $meter->vid)
            ->where('meter_entry', '<', $meter->meter_entry)
            ->orderBy('meter_entry', 'DESC')
            ->first();
        $max = Meter::where('vid', $meter->vid)
            ->where('meter_entry', '>', $meter->meter_entry)
            ->orderBy('meter_entry', 'ASC')
            ->first();
        // dd($min->meter_entry."***".$max->meter_entry);
        if($min && !$max){
            $attributes= request()->validate([
                'vid'=> 'prohibited',
                'meter_entry'=>  'numeric|min:'.($min->meter_entry)+1,
                // 'date' => 'prohibited',
                'status'=> 'prohibited',
                'note'=> 'nullable|string'
            ]);
        }elseif($max && !$min){
            $attributes= request()->validate([
                'vid'=> 'prohibited',
                'meter_entry'=>  'numeric|max:'.(($max->meter_entry)-1).'|min:'.($meter->vehicle->meter_start)+1,
                // 'date' => 'prohibited',
                'status'=> 'prohibited',
                'note'=> 'nullable|string'
            ]);
        }elseif($max && $min){
            $attributes= request()->validate([
                'vid'=> 'prohibited',
                'meter_entry'=>  'numeric|min:'.(($min->meter_entry)+1).'|max:'.($max->meter_entry)-1,
                // 'date' => 'prohibited',
                'status'=> 'prohibited',
                'note'=> 'nullable|string'
            ]);
        }else{
            $attributes= request()->validate([
                'vid'=> 'prohibited',
                'meter_entry'=>  'numeric|min:'.($meter->vehicle->meter_start)+1,
                // 'date' => 'prohibited',
                'status'=> 'prohibited',
                'note'=> 'nullable|string'
            ]);
        }
        $update = Meter::where('id', $meter->id)
        ->update([
            'meter_entry'=> request()->input('meter_entry')
        ]);
        return redirect('/meter/meterVehicles')->with('success', 'Meter reading has been Updated');
    }


    public function meterVehicleFilter(){

        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        // $query = Trip::query();

        if(request()->input('date')){
            $vehicles = Vehicle::latest()
                ->withCount(['meterEntries' => function ($query) use ($start,$end) {
                    $query->whereBetween('date', [$start, $end]);
                }])
                ->withMax(
                    ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'date'
                )
                ->withMin(
                    ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
                )
                ->withMax(
                    ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
                )->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');

        return view('meterVehicles', [
            'vehicles' => $vehicles,
            'start' =>  $start,
            'end' => $end
        ]);
    }

    public function meterEntriesFilter(){

        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Meter::query();
        if(request()->input('date')){
            $meterEntries = $query->latest()
            ->whereBetween('date', [$start, $end])
            ->with('vehicle')
            ->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        return view('meterEntries', [
                'meterEntries' => $meterEntries,
                'start' => $start,
                'end' => $end
        ]);
    }

    public function vehicleMeterEntriesFilter(Vehicle $vehicle)
    {
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Meter::query();
        if(request()->input('date')){
            $meterEntries = $query->latest()
            ->whereBetween('date', [$start, $end])
            ->where('vid', $vehicle->id)
            ->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');

        return view('vehicleMeterEntries', [
            'meterEntries' => $meterEntries,
            'vehicle'=>  $vehicle,
            'start' => $start,
            'end' => $end
        ]);
        // dd($meterEntries);
    }


    public function destroy($meter)
    {
        $data = Meter::findOrFail($meter);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Meter Entry has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
