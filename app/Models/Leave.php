<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'employee_name',
        'begin_date',
        'end_date',
        'leave_type',
        'begin_time',
        'end_time',
        'duration',
        'note',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'employee_code', 'personnel_id');
    }

}
