<?php

namespace App\Http\Controllers;

use App\Models\Routex;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreRoutexRequest;
use App\Http\Requests\UpdateRoutexRequest;

class RoutexController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $routes = Routex::latest()->get();
        return view('routes', [
            'lists' => $routes
        ]);
    }
    public function routeAdd()
    {
        return view('routeAdd');
    }

    public function store()
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'route'=> [
                'required',
                Rule::unique('routexes', 'route')
            ],
            'slabel' => 'nullable|string|min:1|max:255',
            'slat' => 'nullable|numeric',
            'slon' => 'nullable|numeric'
        ]);
        $route= Routex::create([
            'route'=> request()->input('route'),
            'slabel'=> request()->input('slabel'),
            'slat'=> request()->input('slat'),
            'slon'=> request()->input('slon'),
            'added_by' => $added_by
        ]);

        return redirect('/route/routes')->with('success', 'Route has been added');
    }

    public function show(Routex $routex)
    {
        //
    }

    public function edit(Routex $route)
    {
        return view('routeEdit', [
            'route' => $route
        ]);
    }

    public function update(Routex $route)
    {
        // dd(request()->all());
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'route'=> [
                'required',
                Rule::unique('routexes', 'route')->ignore($route->route, 'route'),
            ],
            'slabel' => 'nullable|string|min:1|max:255',
            'slat' => 'nullable|numeric',
            'slon' => 'nullable|numeric'
        ]);
        $update = $route->update([
                'route'=> request()->input('route'),
                'slabel'=> request()->input('slabel'),
                'slat'=> request()->input('slat'),
                'slon'=> request()->input('slon')
            ]);
        return redirect('/route/routes')->with('success', 'Route information updated.');
    }

    public function destroy($route)
    {
        $data = Routex::findOrFail($route);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Route has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
