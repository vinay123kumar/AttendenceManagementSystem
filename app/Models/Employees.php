<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory, Notifiable;

    public function getRouteKeyName()
    {
        return 'name';
    }
    protected $table = 'employees';
    protected $fillable = [
        'name','position', 'email', 'pin_code','permissions'
    ];


    protected $hidden = [
        'pin_code', 'remember_token',
    ];


    public function check()
    {
        return $this->hasMany(Checks::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function latetime()
    {
        return $this->hasMany(latetimes::class);
    }
    public function leave()
    {
        return $this->hasMany(leaves::class);
    }
    public function overtime()
    {
        return $this->hasMany(Overtimes::class);
    }
    public function schedules()
    {
        return $this->belongsToMany('App\Models\Schedule', 'schedule_employees', 'emp_id', 'schedule_id');
    }




}
