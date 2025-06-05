<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'user_id', 'permission'];

    /**
     * Get the user associated with the permission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
