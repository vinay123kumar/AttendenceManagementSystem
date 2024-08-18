<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRec;
use App\Models\Employees;
use App\Models\Schedule;
use PDF;


class EmployeeController extends Controller
{

    public function index()
    {

        return view('admin.employee')->with(['employees' => Employees::all(), 'schedules' => Schedule::all()]);
    }

    public function store(EmployeeRec $request)
    {
        $request->validated();

        $employee = new Employees();
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        if ($request->schedule) {

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);
        }

        // $role = Role::whereSlug('emp')->first();

        // $employee->roles()->attach($role);
        flash()->success('Success', 'Employee Record has been created successfully !');

        return redirect()->route('employees.index')->with('success');
    }
    public function update(EmployeeRec $request, Employees $employee)
    {
        $request->validated();

        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        if ($request->schedule) {

            $employee->schedules()->detach();

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);
        }

        flash()->success('Success', 'Employee Record has been Updated successfully !');

        return redirect()->route('employees.index')->with('success');
    }

    public function destroy(Employees $employee)
    {
        $employee->delete();
        flash()->success('Success', 'Employee Record has been Deleted successfully !');
        return redirect()->route('employees.index')->with('success');
    }
    public function exportPDF()
    {
        $employees = Employees::all();
        // dd($employees);
        $pdf = Pdf::loadView('employees_pdf', compact('employees'));
        return $pdf->download('employees.pdf');
    }
    public function show($id)
    {
        $employee = Employees::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function viewPDF()
    {
        $employees = Employees::all();

        $pdf = PDF::loadView('admin.PDF.employeedetails',['employees'=>$employees])
        ->setpaper('a4','landscape');

        return $pdf->stream();
    }

    public function downloadPDF()
    {
        $employees = Employees::all();

        $pdf = PDF::loadView('admin.PDF.employeedetails',['employees'=>$employees])
        ->setpaper('a4','landscape');

        return $pdf->download('admin.PDF.employeedetails');
    }

}
