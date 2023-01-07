<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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


    public function show(Reminder $reminder)
    {
        //
    }


    public function edit(Reminder $reminder)
    {
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

    public function filter()
    {
        // dd(request()->all());
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Reminder::query();
        if(request()->input('date')){
            $reminders = $query->latest()
            ->whereBetween('date', [$start, $end])
            ->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        //  dd($fuels);
        return view('reminders',[
            'reminders' => $reminders,
            'start' => $start,
            'end' => $end
        ]);
    }
    public function destroy($reminder)
    {
        $data = Reminder::findorFail($reminder);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Reminder has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
