<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $table = 'app_credentials';

    protected $fillable = ['user_id', 'app_name', 'username', 'password', 'link', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
