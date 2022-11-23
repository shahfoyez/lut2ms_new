<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

class ScheduleController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::latest()->get();
        // dd($notices);
        return view('schedules',[
            'schedules' => $schedules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('scheduleAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNoticeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'schedule'=> 'required | min:3 | max:255',
            'image' => 'required|image|max:500',
            'status'=> 'required | boolean',
        ]);

        if (request()->has('image')) {
            // $fileName='FILE_'.md5(date('d-m-Y H:i:s')).$file->getClientOriginalName();
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.$request->image->extension();
            request()->image->move(public_path('assets/uploads/notices'), $imageName);
            $imageName = "assets/uploads/notices/".$imageName;
        }else{
            $imageName = "";
        }
        $notice= Schedule::create([
            'schedule'=> request()->input('schedule'),
            'image' => $imageName,
            'added_by' => $added_by,
            'status'=> request()->input('status'),

        ]);
        return redirect('/schedule/schedules')->with('success', 'Schedule has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        // dd(bcrypt($user->password));
        return view('noticeEdit', [
            'notice' => $schedule
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNoticeRequest  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Schedule $notice)
    {
        $attributes=request()->validate([
            'title'=> 'required | min:3 | max:255',
            'desc'=> 'nullable',
            'image' => 'max:150'
        ]);
        if (request()->has('image')) {
            // File::delete($employee->image);
            if($schedule->image){
                unlink(public_path($notice->image));
            }
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/notices'),$imageName);
            $imageName = "assets/uploads/notices/".$imageName;
        }else{
            $imageName = $schedule->image;
        }
        // dd(request()->all());
        Schedule::where('id', $schedule->id)->update([
            'title'=> request()->input('title'),
            'desc'=> request()->input('desc'),
            'image' => $imageName,
        ]);
        return redirect('/notice/notices')->with('success', 'Notice has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($schedule)
    {
        $data = Schedule::find($schedule);
        // dd($data);
        if($data){
            if ($data->image) {
                unlink(public_path($data->image));
            }
            $data->delete();
            return back()->with('success', 'Notice has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
