<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leaves extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employees::class, 'emp_id');
    }
}
