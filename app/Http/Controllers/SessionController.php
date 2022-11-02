<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Session;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function loginCreate()
    {
    return view('login');
}

    public function check()
    {
        // dd("hello");
        $attributes=request()->validate([
            'username'=> 'required',
            'password'=> 'required'
        ]);

        // attempt to authenticate
        // attempt() does both checking email and password match and signing session
        if(!auth()->attempt($attributes)){
            // if auth failed
            throw ValidationException::withMessages([
                'error'=>'Credential not matched.'
            ]); //automaticly returns current input
        }
        session()->regenerate(); //session fixation

        return redirect('/dashboard')->with('message', 'You are loged In'); //with value assign in session
    }
    public function destroy()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You are loged out!');
    }
}
