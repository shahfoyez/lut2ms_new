<?php

namespace App\Http\Controllers;

use App\Models\Routex;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TestController extends Controller
{
        $vehicles = Vehicle::get();
        $route = Routex::get();
        // concat
        $collection = collect($vehicles);
        $collection = $collection->concat($route);
        dd($collection);

        // aggregates
        $dd = Vehicle::sum('capacity');
        $gg = $vehicles->sum('capacity');
        dd($gg);
        foreach($vehicles as $vehicle){
            $gg = $vehicle->fuels->sum('cost');
            dd($gg);
        }


        $books = Book::with([
            'author' => [
                'contacts',
                'publisher',
            ],
        ])->get();
        // Sometimes you may wish to eager load a relationship but also specify additional query conditions
        $users = User::with(['posts' => function ($query) {
            $query->where('title', 'like', '%code%');
        }])->get();
        $books = Book::without('author')->get();
        $books = Book::with('author')->get();
        $books = Book::with('author.contacts')->get();
        $posts = Post::whereBelongsTo($user)->get();

        // passing user collection
        $posts = Post::whereBelongsTo($users)->get();
        Trip::oldest()->get();
        $trips = Trip::with('vehicle', 'rout', 'employee')->latest()->get();

        //contain
        $collection->contains('New York');
        // key / value pair
        $collection->contains('product', 'Bookcase');
        $collection->contains(function ($value, $key) {
            return $value > 5;
        });
        //count by
        $counted = $collection->countBy();

        // every
        collect([1, 2, 3, 4])->every(function ($value, $key) {
            return $value > 2;
        });

        // first
        collect([1, 2, 3, 4])->first(function ($value, $key) {
            return $value > 2;
        });

        $collection->firstWhere('name', 'Linda');

        // group by
        $grouped = $collection->groupBy(function ($item, $key) {
            return substr($item['account_id'], -3);
        });

        // $grouped->all();

        /*
            [
                'x10' => [
                    ['account_id' => 'account-x10', 'product' => 'Chair'],
                    ['account_id' => 'account-x10', 'product' => 'Bookcase'],
                ],
                'x11' => [
                    ['account_id' => 'account-x11', 'product' => 'Desk'],
                ],
            ]
        */

        $sorted = $collection->sortBy('price');

        $subset = $collection->takeUntil(function ($item) {
            return $item >= 3;
        });

        $posts = Post::withSum('comments', 'votes')->get();
        // table name different
        $vehicles = Vehicle::withSum('fuels', 'table_name.column')->get();
        //Latest oldest first
        $Fuel = Fuel::oldest('date')
            ->where('vid', $attributes['vid'])
            ->get();

        $flight = Fuel::latest()->firstWhere('vid', $attributes['vid']);

        // validation error
        $error = \Illuminate\Validation\ValidationException::withMessages([
            'field_name_1' => ['Validation Message #1'],
            'field_name_2' => ['Validation Message #2'],
         ]);
         throw $error;
         // or
         use Illuminate\Validation\ValidationException;

        throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);


        // manually
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                ->withErrors($validator)
                ->withInput();
        }
        // specefic column
        $minEntry = Vehicle::Where('id', $request->input('vid'))->first(['meter_start'])->meter_start;


        $vehicles = Vehicle::withSum('fuels', 'quantity')
            ->withCount('fuels')
            ->withSum('fuels', 'cost')
            ->withMax('fuels', 'date')
            ->withMax('meterEntries', 'meter_entry')
            ->get();
        // VALIDATION
        'email' => [
            'required',
            Rule::exists('staff')->where(function ($query) {
                return $query->where('account_id', 1);
            }),
        ],

        $maintenanceRecords = Maintenance::latest('from')->with('vehicle')->paginate(2);
        $maintenanceRecords->appends(['sort' => 'votes']);
        $users->withPath('/admin/users');
        dd($maintenanceRecords);
        // Scheduler
        $schedule->call(function () {
            DB::table('tasks')->whereDate('endDate', '<', date('Y/m/d H:i'))->update(['status', 'Expired']);
        })->everyMinute();

        $rr = Employee::withTrashed();
        $flight->trashed();
        $flight->restore();
        Flight::withTrashed()
        ->where('airline_id', 1)
        ->restore();


    public function edit(Stoppage $stoppage)
    {
        $routes = Routex::latest()->get();
        return view('stoppageEdit', [
            'stoppage' => $stoppage,
            'routes' => $routes
        ]);
    }

    public function update(Stoppage $stoppage)
    {
        $attributes=request()->validate([
            'route' => 'required',
            'slabel' => 'required|string|min:1|max:255',
            'slat' => 'required|numeric|between:-90,90',
            'slon' => 'required|numeric|between:-90,90'
        ]);
        $update = $stoppage->update([
                'route'=> request()->input('route'),
                'slabel'=> request()->input('slabel'),
                'slat'=> request()->input('slat'),
                'slon'=> request()->input('slon')
            ]);
        return redirect('/route/stoppages')->with('success', 'Stoppage information updated.');
    }

    public function destroy($stoppage)
    {
        $data = Stoppage::find($stoppage);
        if($data){
            $data->delete();
            return back()->with('success', 'Stoppage has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
    Post::query()
    ->with(['user' => function ($query) {
        $query->select('id', 'username');
    }])
    ->get();

    $books = App\Book::with('author.contacts')->get();
}
