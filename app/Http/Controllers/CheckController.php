<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Employees;
use App\Models\Leave;
use App\Models\leaves;

class CheckController extends Controller
{
    public function index()
    {
        return view('admin.check')->with(['employees' => Employees::all()]);
    }

    public function CheckStore(Request $request)
    {
        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employees::whereId(request('emp_id'))->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(0)
                                ->first()
                        ) {
                            $data = new Attendance();

                            $data->emp_id = $key;
                            $emp_req = Employees::whereId($data->emp_id)->first();
                            $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
                            $data->attendance_date = $keys;

                            $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
                            if (!($emps > $data->attendance_time)) {
                                $data->status = 0;

                            }
                            $data->save();
                        }
                    }
                }
            }
        }
        if (isset($request->leave)) {
            foreach ($request->leave as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employees::whereId(request('emp_id'))->first()) {
                        if (
                            !leaves::whereLeave_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(1)
                                ->first()
                        ) {
                            $data = new leaves();
                            $data->emp_id = $key;
                            $emp_req = Employees::whereId($data->emp_id)->first();
                            $data->leave_time = $emp_req->schedules->first()->time_out;
                            $data->leave_date = $keys;
                            if ($employee->schedules->first()->time_out <= $data->leave_time) {
                                $data->status = 1;

                            }

                            $data->save();
                        }
                    }
                }
            }
        }
        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }
    public function sheetReport()
    {

    return view('admin.sheet-report')->with(['employees' => Employees::all()]);
    }
}
