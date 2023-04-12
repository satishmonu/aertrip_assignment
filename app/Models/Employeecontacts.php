<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeecontacts extends Model
{
    protected $fillable = ['employee_id','phone_number', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

