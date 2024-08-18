<?php

namespsace App\Http\Controllers;

use DateTime;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\attendence;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AttendanceEmp;
use App\Models\Attendance;
use App\Models\Employees;
use App\Models\latetimes;

class AttendanceController extends Controller
{

    public function index()
    {
        return view('admin.attendence')->with(['attendances' => Attendance::all()]);
    }

    //show late time
    public function indexLatetime()
    {
        return view('admin.latetime')->with(['latetimes' => latetimes::all()]);
    }



    // public static function lateTime(Employee $employee)
    // {
    //     $current_t = new DateTime(date('H:i:s'));
    //     $start_t = new DateTime($employee->schedules->first()->time_in);
    //     $difference = $start_t->diff($current_t)->format('%H:%I:%S');

    //     $latetime = new Latetime();
    //     $latetime->emp_id = $employee->id;
    //     $latetime->duration = $difference;
    //     $latetime->latetime_date = date('Y-m-d');
    //     $latetime->save();
    // }

    public static function lateTimeDevice($att_dateTime, Employees $employee)
    {
        $attendance_time = new DateTime($att_dateTime);
        $checkin = new DateTime($employee->schedules->first()->time_in);
        $difference = $checkin->diff($attendance_time)->format('%H:%I:%S');

        $latetime = new latetimes();
        $latetime->emp_id = $employee->id;
        $latetime->duration = $difference;
        $latetime->latetime_date = date('Y-m-d', strtotime($att_dateTime));
        $latetime->save();
    }

}
