<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checks extends Model
{
    public function employees()
    {
        return $this->belongsTo(Employees::class);
    }

}
