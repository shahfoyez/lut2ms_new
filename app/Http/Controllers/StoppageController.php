<?php

namespace App\Http\Controllers;

use App\Models\Routex;
use App\Models\Stoppage;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreStoppageRequest;
use App\Http\Requests\UpdateStoppageRequest;

class StoppageController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        $stoppages = Stoppage::orderBy('created_at', 'DESC')->get();
        return view('stoppages', [
            'lists' => $stoppages,
        ]);
    }
    public function stopageAdd()
    {
        $routes = Routex::orderBy('created_at', 'ASC')->get();
        return view('stoppageAdd', [
            'routes' => $routes
        ]);
    }

    public function store()
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'route' => 'required',
            'slabel' => 'required|string|min:1|max:255',
            'slat' => 'required|numeric',
            'slon' => 'required|numeric'
        ]);
        $stoppage= Stoppage::create([
            'route'=> request()->input('route'),
            'slabel'=> request()->input('slabel'),
            'slat'=> request()->input('slat'),
            'slon'=> request()->input('slon'),
            'added_by' => $added_by
        ]);
        return redirect("/route/stoppages")->with('success', 'Stopage has been added');
    }

    public function show(Stoppage $stoppage)
    {
        //
    }

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
            'slat' => 'required|numeric',
            'slon' => 'required|numeric'
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
        $data = Stoppage::findOrFail($stoppage);
        if($data){
            $data->delete();
            return back()->with('success', 'Stoppage has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
