<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';


    protected $fillable = [
        'user_id', 'usefulness', 'length', 'staff_insight', 'product_insight', 'info_insight',
        'it_insight', 'interaction', 'culture', 'experience', 'recommendation', 'most_fav',
        'least_fav', 'addition', 'suggestion'
    ];

    public static function getAvg($col)
    {
        $average = self::where(DB::raw('YEAR(created_at)'), Carbon::now()->year)
            ->select(DB::raw("AVG({$col}) as average"))
            ->first()->average;

        return number_format($average, 2) .' Avg.';
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
