<?php

namespace App\Models;

use App\Services\DepartmentDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DMS extends Model
{
    use HasFactory;

    protected $table = 'dms';
    protected $fillable = ['file', 'code', 'version', 'title', 'status', 'owners', 'revision', 'combined_read_count', 'extra'];
    protected $casts = [
        'owners' => 'array',
        'extra' => 'array',
    ];

    private static $statusMapping = [
        'live' => 'فعال',
        'under_review' => 'در حال بررسی',
        'obsolete' => 'منسوخ شده',
    ];

    private static $statusIconMapping = [
        'live' => '<i class="fas fa-check-circle text-green-500"></i>',
        'under_review' => '<i class="fas fa-hourglass-half text-yellow-500"></i>',
        'obsolete' => '<i class="fas fa-times-circle text-red-500"></i>',
    ];


    public function reads()
    {
        return $this->hasMany(Read::class, 'document_id');
    }

    public function getAllDepartmentNamesInFarsi()
    {
        if (collect($this->owners)->contains('ALL')) {
            return 'همه واحد ها';
        }
        return collect($this->owners)->map(function ($ownerCode) {
            return DepartmentDetails::getDescription($ownerCode);
        })->implode(', ');
    }

    public function getStatusInFarsi()
    {
        return self::$statusMapping[$this->status] ?? $this->status;
    }

    public function getStatusIcon()
    {
        return self::$statusIconMapping[$this->status] ?? $this->status;
    }

    public static function getUnsignedDocumentsCount()
    {
        return self::where('status', 'live')
            ->where(function ($query) {
                $query->whereJsonContains('owners', 'ALL')
                    ->orWhereJsonContains('owners', auth()->user()->profile->department);
            })
            ->whereDoesntHave('reads', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->count();
    }

    public static function getNotReadDocumentsCount()
    {
        $userId = auth()->id();

        return Read::where('user_id', $userId)
            ->where('read', true)
            ->where('read_count', 0)
            ->count();
    }

    public function scopeVisibleToUser($query)
    {
        return $query->where('status', 'live')
            ->where(function ($query) {
                $query->whereJsonContains('owners', auth()->user()->profile->department)
                    ->orWhereJsonContains('owners', 'ALL');
            });
    }

    public static function getDocumentCounts()
    {
        return Cache::remember('dms_document_counts', 600, function () {
            return DB::table('dms')->selectRaw("
                COUNT(CASE WHEN status = 'live' THEN 1 END) AS live_count,
                COUNT(CASE WHEN status = 'under_review' THEN 1 END) AS under_review_count,
                COUNT(CASE WHEN status = 'obsolete' THEN 1 END) AS archived_count
            ")->first();
        });
    }
}
