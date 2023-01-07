<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        $employees = Employee::latest()->with('departmentR','designationR')->get();
        return view('employees', [
            'employees' => $employees
        ]);
    }
    public function employeeAdd()
    {
        $departments = Department::latest()->get();
        $designations = Designation::latest()->get();
        return view('employeeAdd', [
            'departments' => $departments,
            'designations' => $designations
        ]);
    }

    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
            'idNumber'=> ['required', Rule::unique('employees', 'idNumber')],
            'phone'=> 'required',
            'image' => 'image|max:150'
        ]);

        if (request()->has('image')) {
            // $fileName='FILE_'.md5(date('d-m-Y H:i:s')).$file->getClientOriginalName();
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.$request->image->extension();
            request()->image->move(public_path('assets/uploads/employees'),$imageName);
            $imageName = "assets/uploads/employees/".$imageName;
        }else{
            $imageName = "";
        }
        $employee= Employee::create([
            'name'=> request()->input('name'),
            'idNumber'=> request()->input('idNumber'),
            'phone'=> request()->input('phone'),
            'image' => $imageName,
            'address'=> request()->input('address'),
            'department'=> request()->input('department'),
            'designation'=> request()->input('designation'),
            'added_by' => $added_by,
            'status' => 0
        ]);
        return redirect('/employee/employees')->with('success', 'Employee has been created');
    }

    public function edit($employee)
    {
        $employee = Employee::with('departmentR','designationR')->findOrFail($employee);
        $departments = Department::latest()->get();
        $designations = Designation::latest()->get();
        // dd( $employee);
        return view('employeeEdit', [
            'departments' => $departments,
            'designations' =>  $designations,
            'employee' => $employee
        ]);
    }

    public function update(Employee $employee)
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
            'idNumber'=> [
                'required',
                Rule::unique('employees', 'idNumber')->ignore($employee->idNumber, 'idNumber'),
            ],
            'phone'=> 'required',
            'image' => 'image|nullable|max:150'
        ]);
        if (request()->has('image')) {
            // File::delete($employee->image);
            if($employee->image){
                unlink(public_path($employee->image));
            }
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/employees'),$imageName);
            $imageName = "assets/uploads/employees/".$imageName;
        }else{
            $imageName = $employee->image;
        }
        $update = Employee::where('id', $employee->id)
            ->update([
                'name'=> request()->input('name'),
                'idNumber'=> request()->input('idNumber'),
                'phone'=> request()->input('phone'),
                'image' => $imageName,
                'address'=> request()->input('address'),
                'department'=> request()->input('department'),
                'designation'=> request()->input('designation'),
                'added_by' => $added_by
            ]);
        return redirect('/employee/employees')->with('success', 'Employee information updated.');
    }

    public function destroy($employee)
    {
        $data = Employee::findOrFail($employee);
        if($data->image){
            unlink(public_path($data->image));
        }
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Employee has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }

    // Department & Designation
    public function departments()
    {
        $departments = Department::withCount('employees')->latest()->get();
        // dd( $departments);
        return view('departments', [
            'departments' => $departments
        ]);
    }
    public function designations()
    {
        $designations = Designation::latest()->withCount('employees')->get();
        return view('designations', [
            'designations' => $designations
        ]);
    }

    public function departmentCreate()
    {
        return view('departmentAdd');
    }

    public function designationCreate()
    {
        return view('designationAdd');
    }

    public function departmentAdd()
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255'
        ]);
        $create= Department::create([
            'name'=> request()->input('name'),
            'added_by' => $added_by
        ]);
        return redirect('/employee/departments')->with('success', 'Department has been added');
    }

    public function designationAdd()
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255'
        ]);
        $create= Designation::create([
            'name'=> request()->input('name'),
            'added_by' => $added_by
        ]);
        return redirect('/employee/designations')->with('success', 'Designation has been added');
    }
    public function designationDestroy($designation)
    {
        $data = Designation::findOrFail($designation);
        // dd($data);
        if($data){
            $data->delete();
            return back()->with('success', 'Designation has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function departmentDestroy($department)
    {
        $data = Department::findOrFail($department);
        // dd($data);
        if($data){
            if($data->image){
                unlink(public_path($data->image));
            }
            $data->delete();
            return back()->with('success', 'Department has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function departmentEdit(Department $department)
    {
        return view('departmentEdit', [
            'department' => $department
        ]);
    }

    public function departmentUpdate($department)
    {
        // dd(request()->all());
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
        ]);
        $update = Department::where('id', $department)
            ->update([
                'name'=> request()->input('name')
            ]);
        return redirect('/employee/departments')->with('success', 'Department information updated.');
    }

    public function designationEdit(Designation $designation)
    {
        return view('designationEdit', [
            'designation' => $designation
        ]);
    }

    public function designationUpdate($designation)
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'name'=> 'required | min:3 | max:255',
        ]);
        $update = Designation::where('id', $designation)
            ->update([
                'name'=> request()->input('name')
            ]);
        return redirect('/employee/designations')->with('success', 'Designation information updated.');
    }
}
