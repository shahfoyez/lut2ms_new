<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fuel;
use App\Models\Meter;
use App\Models\Vehicle;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;

class MaintenanceController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::withCount('maintenanceEntries')
            ->withSum('maintenanceEntries', 'cost')
            ->withMax('maintenanceEntries', 'from')
            ->latest()->get();
        return view('maintenanceVehicles', [
            'vehicles' => $vehicles
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        $vehicles = Vehicle::latest()->get();
        return view('maintenanceAdd', [
            'vehicles' => $vehicles,
            'selVehicle' => $vehicle
        ]);
    }
    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        if($request->input('from')){
            $from = $request->input('from');
            $from = Carbon::createFromFormat('Y-m-d\TH:i', $from)->format('Y-m-d H:i A');
        }

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
        $maintenanceRecords = Maintenance::with('vehicle')->latest('from')->get();
        return view('maintenanceRecords', [
            'maintenanceRecords' => $maintenanceRecords
        ]);
    }
    public function  vehicleMaintenanceEntries($vid)
    {
        $vehicle = Vehicle::findOrFail($vid)->codeName;
        $maintenanceRecords = Maintenance::where('vid', $vid)->latest('from')->get();
        // dd( $vehicle);
        // dd($maintenanceRecords);
        return view('vehicleMaintenanceRecords', [
                'maintenanceRecords' => $maintenanceRecords,
                'vehicle' => $vehicle
        ]);
    }

    public function edit(Maintenance $maintenance)
    {
        $maintenance = $maintenance->load(['vehicle' => function($query){
            $query->select('id', 'codeName')->get();
        }]);

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



    public function maintenanceVehiclesFilter(){
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $vehicles = Vehicle::withCount(['maintenanceEntries' => function ($query) use ($start,$end) {
                $query->whereBetween('from', [$start, $end]);
            }])
            ->withSum(
                ['maintenanceEntries' => fn($query) => $query->whereBetween('from', [$start, $end])], 'cost'
            )
            ->withMax(
                ['maintenanceEntries' => fn($query) => $query->whereBetween('from', [$start, $end])], 'from'
            )
            ->latest()->get();
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        return view('maintenanceVehicles', [
            'vehicles' => $vehicles,
            'start' => $start,
            'end' => $end
        ]);
    }
    public function maintenanceRecordsFilter(){
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');
        if(request()->input('date')){
            $maintenanceRecords = Maintenance::whereBetween('from', [$start, $end])
            ->with('vehicle')
            ->latest()->get();
        }
        // dd($maintenanceRecords);

        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        return view('maintenanceRecords', [
            'maintenanceRecords' => $maintenanceRecords,
            'start' => $start,
            'end' => $end
        ]);
    }
    public function maintenanceStats()
    {
        // $maintenance = Maintenance::selectRaw('*', 'DATE(created_at) as date')
        //     ->latest()
        //     ->get()
        //     ->groupByRaw('DATE(created_at)', true);
        // $maintenance = Maintenance::get()
        // ->groupBy('MONTH(from)', true);
        // dd(date);
        $maintenance= Maintenance::whereYear('from', date('Y'))
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->from)->format('F');
            })->take(7);

        // $maintenance = Maintenance::select(
        //     "*" , DB::raw("(DATE_FORMAT(created_at, '%m-%Y')) as month_year"))
        //     ->groupBy(DB::raw("DATE_FORMAT(created_at, 'M')"))
        //     ->get();
        // $maintenance = DB::table('maintenances')
        //     ->select('*')
        //     ->groupByRaw('MONTH(created_at)')
        //     ->get();
        // dd($maintenance);

        // return view('maintenanceAdd', [
        //     'vehicles' => $vehicles,
        //     'selVehicle' => $vehicle
        // ]);
    }

    public function destroy($maintenance)
    {
        $data = Maintenance::findOrFail($maintenance);
        if($data){
            $data->delete();
            return back()->with('success', 'Maintenance  Record has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
