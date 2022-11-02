<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Http\Requests\StoreReminderRequest;
use App\Http\Requests\UpdateReminderRequest;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminders = Reminder::latest()->get();
        return view('reminders',[
            'reminders' => $reminders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reminderAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReminderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $added_by = auth()->user()->id;
        $attributes= request()->validate([
            'title'=> 'required',
            'desc'=>  'nullable',
            'date' => 'required|date|after:today'
        ]);
        $create= Reminder::create([
            'title'=> request()->input('title'),
            'desc'=> request()->input('desc'),
            'date'=> request()->input('date'),
            'status'=> 1,
            'added_by' => $added_by
        ]);
        return redirect('reminder/reminders')->with('success', 'Reminder added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit($reminder)
    {
        $reminder = Reminder::find($reminder);
        return view('reminderEdit', [
             'reminder' => $reminder
        ]);
    }

    public function update(Reminder $reminder)
    {
        $attributes= request()->validate([
            'title'=> 'required',
            'desc'=>  'nullable',
            'date' => 'required|date|after_or_equal:'.$reminder->date
        ]);
        $create= Reminder::where('id', $reminder->id)->update([
            'title'=> request()->input('title'),
            'desc'=> request()->input('desc'),
            'date'=> request()->input('date'),
        ]);
        return redirect('/reminder/reminders')->with('success', 'Reminder has been Updated');
    }

    public function destroy($reminder)
    {
        $data = Reminder::find($reminder);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Reminder has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
