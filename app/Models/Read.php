<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    use HasFactory;

    protected $table = 'reads';
    protected $fillable = ['document_id', 'user_id', 'read', 'read_count', 'combined_read_count'];

    public function doc()
    {
        return $this->belongsTo(Dms::class, 'document_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
