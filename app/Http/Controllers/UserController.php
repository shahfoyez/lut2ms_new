<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('userAdd');
    }
    public function store()
    {
        // dd(request()->all());
        $attributes=request()->validate([
            'name'=> 'required | min:1 | max:255',
            'username'=> ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'phone'=> 'required',
            'password'=> 'required',
            'role' => 'required'
        ]);

        // dd(request()->input('fname'));
        $user= User::create([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'phone'=> request()->input('phone'),
            'password'=> request()->input('password'),
            'role' => request()->input('role'),
        ]);

        return back()->with('success', 'User has been created');
    }
    public function show(User $user)
    {
        $stopage = Stopage::all();
        return view('profile', [
            'user' => $user,
            'stopage' => $stopage
        ]);
    }
    public function update(User $user)
    {
        // dd(request()->all());
        User::where('id', $user->id)->update([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'idNumber'=> request()->input('idNumber'),
            'phone'=> request()->input('phone'),
            'role'=> request()->input('role'),
            'stoppage'=> request()->input('stoppage'),
            'batch'=> request()->input('batch'),
            'section'=> request()->input('section'),
            'designation'=> request()->input('designation'),
            'codename' => request()->input('codename')
        ]);

        return back()->with('success', 'Profile Updated');
    }
    public function destroy($user)
    {
        $data = User::find($user);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'User has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
