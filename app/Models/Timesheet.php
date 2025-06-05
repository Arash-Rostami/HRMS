<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code', 'employee_name', 'entry_time', 'exit_time', 'mission', 'presence', 'note',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'employee_code', 'personnel_id');
    }
}
