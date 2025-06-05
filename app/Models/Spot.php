<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number', 'floor', 'card'
    ];


    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Support\Collection
     */
    public function getFromTo($from, $to): \Illuminate\Support\Collection
    {
        return $this->where('id', '>', $from)
            ->where('id', '<', $to)->get();
    }

    /**
     * @param $num
     * @return Seat|Model|object|null
     */
    public function getId($num)
    {
        return $this->where('number', '=', $num)->first();
    }

    public function parks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Park::class);
    }
}
