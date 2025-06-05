<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number', 'extension', 'location'
    ];

    public function desks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Desk::class);
    }

    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Support\Collection
     */
    public function getFromTo($from, $to): \Illuminate\Support\Collection
    {
        return $this->skip($from)->take($to)->get();
    }

    /**
     * @param $num
     * @return Seat|Model|object|null
     */
    public function getId($num)
    {
        return $this->where('number', '=', $num)->first();
    }

    public static function getExtension($num)
    {
        return self::where('extension', $num)->get();
    }

    public static function getLocation($num)
    {
        return self::where('location', $num)->get();
    }

    public static function getNumber($num)
    {
        return self::where('id', $num)->get();
    }


}
