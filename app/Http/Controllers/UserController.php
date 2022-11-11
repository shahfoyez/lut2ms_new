<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
        return view('userAdd');
    }
    public function store()
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
        // dd(request()->all());
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
            'username'=> ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'phone'=> 'nullable|numeric',
            'password'=> 'required|min:5|max:10',
            'role' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        // dd(request()->input('fname'));
        $user= User::create([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'phone'=> request()->input('phone'),
            'password'=> request()->input('password'),
            'role' => request()->input('role'),
            'status' => request()->input('status'),
        ]);

        return redirect('user/users')->with('success', 'User has been created');
    }
    public function show()
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
        $userId = auth()->user()->id;
        $users = User::all();
        // $users = User::query->without(['users' => function ($query) {
        //     $query->select('id', $userId);
        // }])->get();

        // dd($users);
        return view('users', [
            'users' => $users
        ]);
    }
    public function edit(User $user)
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
        // dd(bcrypt($user->password));
        return view('userEdit', [
            'user' => $user
        ]);
    }
    public function update(User $user)
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
          // dd(request()->all());
          $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
            'username'=> ['required', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($user->username, 'username')],
            'phone'=> 'nullable|numeric',
            'role' => 'required|numeric',
            'status' => 'required|numeric'
        ]);
        // dd(request()->all());
        User::where('id', $user->id)->update([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'phone'=> request()->input('phone'),
            'role'=> request()->input('role'),
            'status'=> request()->input('status'),
        ]);
        return redirect('/user/users')->with('success', 'Profile Updated');
    }
    public function destroy($user)
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
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
