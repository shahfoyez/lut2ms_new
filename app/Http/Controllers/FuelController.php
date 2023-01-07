<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fuel;
use App\Models\Trip;
use App\Models\Routex;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFuelRequest;
use App\Http\Requests\UpdateFuelRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class FuelController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::withSum('fuels', 'quantity')
            ->withCount('fuels')
            ->withSum('fuels', 'cost')
            ->withMax('fuels', 'date')
            ->withMax('meterEntries', 'meter_entry')
            ->withMin('meterEntries', 'meter_entry')
            ->get();


        // dd($vehicles);
        return view('fuelVehicles', [
            'vehicles' => $vehicles
        ]);
    }
    public function create(Vehicle $vehicle)
    {
        $vehicles = Vehicle::get();
        return view('fuelAdd', [
            'vehicles' => $vehicles,
            'selVehicle' => $vehicle
        ]);
    }
    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        $fuel = Fuel::latest('date')->firstWhere('vid', $request->input('vid'));
        $status = $request->input('status');
        if($fuel){
            $newEntry = $request->input('date');
            $new = Carbon::createFromFormat('Y-m-d\TH:i', $newEntry)->format('Y-m-d H:i');
            $prev =  $fuel->date->format('Y-m-d H:i');
            $prefix = $status == 2 ? "before" : "after";
            $attributes= $request->validate([
                'vid'=> 'required',
                'fuelType'=>  'nullable|string',
                'quantity'=> 'required | numeric | min:0 | max:100',
                'cost'=> 'nullable|numeric|min:0|max:100000',
                'date' => 'required|date|'.$prefix.':'.$prev,
                'status'=> 'required',
                'note'=> 'nullable'
            ],
            [
                'date.'.$prefix => 'Date should be '.$prefix." ".$prev
            ]);
            if ($status == 1) {
                $update = $fuel->update([
                    'status' => 0
                ]);
            }
        }else{
            $attributes= $request->validate([
                'vid'=> 'required',
                'fuelType'=>  'nullable|string',
                'quantity'=> 'required| numeric|min:0|max:100',
                'cost'=> 'nullable|numeric|min:0|max:100000',
                'date' => 'required|date',
                'status'=> 'required',
                'note'=> 'nullable|string'
            ]);
        }
        $create= Fuel::create([
            'vid'=> $request->input('vid'),
            'fuelType'=> $request->input('fuelType'),
            'quantity'=> $request->input('quantity'),
            'cost' =>  $request->input('cost'),
            'date'=> $request->input('date'),
            'status'=> $request->input('status'),
            'note' => $request->input('note'),
            'added_by' => $added_by
        ]);
        return redirect('/fuel/fuelVehicles')->with('success', 'Fuel record has been added');
    }
    public function show()
    {
        $fuels = Fuel::latest()->with('vehicle')->get();
        return view('fuelRecords', [
                'fuels' => $fuels
        ]);
    }
    public function vehicleFuels($vid){
        $vehicle = Vehicle::findOrFail($vid);
        $fuels = Fuel::latest('date')
            ->where('vid', $vid)
            ->get();
        return view('vehicleFuels',[
            'fuels' => $fuels,
            'vehicle' => $vehicle
        ]);
    }

    public function edit($fuel)
    {
        $fuel = Fuel::with('vehicle:id,id,codeName')->findOrFail($fuel);
        return view('fuelEdit', [
            'fuel' => $fuel
        ]);
    }
    public function update(Fuel $fuel)
    {
        $attributes= request()->validate([
            'fuelType'=>  'nullable|string',
            'quantity'=> 'required|numeric',
            'cost'=> 'nullable|numeric',
            'note'=> 'nullable|string'
        ]);
        $create=  $fuel->update([
            'fuelType'=> request()->input('fuelType'),
            'quantity'=> request()->input('quantity'),
            'cost' =>  request()->input('cost'),
            'note' => request()->input('note'),
        ]);
        return redirect('/fuel/fuelRecords')->with('success', 'Fuel record has been added');
    }

    public function filter()
    {
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        // $query = Trip::query();

        if(request()->input('date')){
            $vehicles = Vehicle::withSum(['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'quantity')
                ->withCount(['fuels' => function ($query) use ($start,$end) {
                    $query->whereBetween('date', [$start, $end]);
                }])
                ->withSum(
                    ['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'cost'
                )
                ->withMax(
                    ['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'date'
                )
                ->withMax(
                    ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
                )
                ->withMin(
                    ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
                )->get();
                // dd($vehicles);
        }
        // dd($vehicles);
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        return view('fuelVehicles', [
            'vehicles' => $vehicles,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function fuelRecordsfilter()
    {
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Fuel::query();
        if(request()->input('date')){
            $fuels = $query->whereBetween('date', [$start, $end])
            ->with('vehicle')
            ->latest()->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        //  dd($fuels);
        return view('fuelRecords', [
             'fuels' => $fuels,
             'start' => $start,
             'end' => $end
         ]);
    }

    public function vehicleFuelsFilter($vid)
    {
        $vehicle = Vehicle::findOrFail($vid);
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Fuel::query();
        if(request()->input('date')){
            $fuels = $query->latest()
            ->whereBetween('date', [$start, $end])
            ->where('vid', $vid)
            ->get();
        }
        // dd($fuels);
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        //  dd($fuels);
         return view('vehicleFuels', [
            'fuels' => $fuels,
            'vehicle' => $vehicle,
            'start' => $start,
            'end' => $end
         ]);
    }

    public function destroy($fuel)
    {
        $data = Fuel::findOrFail($fuel);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Fuel Record has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
