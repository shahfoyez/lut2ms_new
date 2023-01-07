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
            'image' => 'image|max:150',
            'status' => 'required|numeric'
        ]);
        if (request()->has('image')) {
            // $fileName='FILE_'.md5(date('d-m-Y H:i:s')).$file->getClientOriginalName();
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/users'),$imageName);
            $imageName = "assets/uploads/users/".$imageName;
        }else{
            $imageName = "";
        }

        // dd(request()->input('fname'));
        $user= User::create([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'phone'=> request()->input('phone'),
            'password'=> request()->input('password'),
            'role' => request()->input('role'),
            'image' => $imageName,
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
            'status' => 'required|numeric',
            'image' => 'image|nullable|max:150'
        ]);
        if (request()->has('image')) {
            // File::delete($employee->image);
            if($user->image){
                unlink(public_path($user->image));
            }
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/users'),$imageName);
            $imageName = "assets/uploads/users/".$imageName;
        }else{
            $imageName = $user->image;
        }
        // dd(request()->all());
        User::where('id', $user->id)->update([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'phone'=> request()->input('phone'),
            'role'=> request()->input('role'),
            'image' => $imageName,
            'status'=> request()->input('status'),
        ]);
        return redirect('/user/users')->with('success', 'Profile Updated');
    }
    public function profileUpdate(User $user)
    {

        if(auth()->user()->id != $user->id){
            abort(404);
        }
          // dd(request()->all());
          $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
            'username'=> ['required', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($user->username, 'username')],
            'phone'=> 'nullable|numeric',
            'image' => 'image|nullable|max:150'
        ]);
        if (request()->has('image')) {
            // File::delete($employee->image);
            if($user->image){
                unlink(public_path($user->image));
            }
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/users'),$imageName);
            $imageName = "assets/uploads/users/".$imageName;
        }else{
            $imageName = $user->image;
        }
        // dd(request()->all());
        User::where('id', $user->id)->update([
            'name'=> request()->input('name'),
            'username'=> request()->input('username'),
            'phone'=> request()->input('phone'),
            'image' => $imageName,
        ]);
        return redirect('/user/profile')->with('success', 'You Profile has been Updated!');
    }
    public function profile()
    {
        $user = auth()->user();

        // dd(bcrypt($user->password));
        return view('userProfile', [
            'user' => $user
        ]);
    }
    public function destroy($user)
    {
        if(auth()->user()->role != 1){
            abort(404);
        }
        $data = User::findOrFail($user);
        // dd($data);
        if($data){
            if($data->image){
                unlink(public_path($data->image));
            }
            $data->delete();
            return back()->with('success', 'User has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
