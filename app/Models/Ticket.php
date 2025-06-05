<?php

namespace App\Models;

use App\Observers\TicketObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => TicketObserver::class,
        'updated' => TicketObserver::class,
    ];

    public $preventObserverUpdate = false;

    protected $fillable = [
        'requester_id',
        'request_type',
        'request_area',
        'request_subject',
        'description',
        'priority',
        'attachment',
        'additional_notes',
        'assigned_to',
        'completion_deadline',
        'completion_date',
        'action_result',
        'status',
        'effectiveness',
        'satisfaction_score',
        'requester_files',
        'assignee_files',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array',
        'completion_deadline' => 'datetime',
        'completion_date' => 'datetime',
        'satisfaction_score' => 'float',
        'requester_files' => 'array',
        'assignee_files' => 'array',
    ];

    public static $requestTypeOptions = [
        'support' => 'Support',
        'access' => 'Access',
    ];

    public static $requestAreaOptions = [
        'support' => [
            '' => 'Select an option',
            'windows_office' => 'Windows & Software',
            'vpn' => 'Internet, Wifi & VPN',
            'voip_telephone' => 'Telephone, VoIP & SIM Card',
            'printer_scanner' => 'Printer, Scanner & Copier Devices',
            'remote_working' => 'Remote Working & Forticlient',
            'host_domain' => 'Host, Domain & Website',
            'backups_restore' => 'Backup, Restore & Archive',
            'purchase_requests' => 'Item & Purchase Requests and Maintenance',
            'generate_bi_reports' => 'Generate or Modify Organizational Reports',
            'other' => 'Other'
        ],
        'access' => [
            '' => 'Select an option',
            'bi' => 'BI',
            'rahkaran' => 'Rahkaran',
            'file_server' => 'File Server',
            'mizito' => 'Mizito',
            'chargoon' => 'Chargoon',
            'hrms' => 'HRMS',
            'bms' => 'BMS',
            'sarv_crm' => 'Sarv CRM',
            'email' => 'Email',
            'other' => 'Other',
        ],
    ];

    public static function getOpenTicketCount(): int
    {
        return self::where('requester_id', auth()->id())
            ->where('status', 'open')
            ->count();
    }

    public static function getInProgressTicketCount(): int
    {
        return self::where('requester_id', auth()->id())
            ->where('status', 'in-progress')
            ->count();
    }


    public static function getStatistics()
    {
        return Cache::remember('ticket_statistics', 600, function () {
            return DB::table('tickets')->selectRaw("
                COUNT(CASE WHEN status = 'open' THEN 1 END) AS open_count,
                COUNT(CASE WHEN status = 'in-progress' THEN 1 END) AS in_progress_count,
                COUNT(CASE WHEN status = 'closed' THEN 1 END) AS closed_count,
                COUNT(CASE WHEN status = 'open' AND priority = 'high' THEN 1 END) AS high_priority_count,
                ROUND(AVG(CASE WHEN status = 'closed' AND satisfaction_score IS NOT NULL AND satisfaction_score != 0 THEN satisfaction_score END), 1) AS average_satisfaction_score,
                ROUND(AVG(CASE WHEN status = 'closed' AND effectiveness IS NOT NULL AND effectiveness != 0 THEN effectiveness END), 1) AS average_effectiveness_score,
                COUNT(CASE WHEN completion_deadline IS NOT NULL
                           AND completion_date IS NOT NULL
                           AND completion_deadline < completion_date THEN 1 END) AS overdue_count,
                COUNT(CASE WHEN request_type = 'support' THEN 1 END) AS support_count,
                COUNT(CASE WHEN request_type = 'access' THEN 1 END) AS access_count
        ")->first();
        });
    }


    public function getRequestAreaOptions($requestType, $requestArea)
    {
        if (isset(self::$requestAreaOptions[$requestType][$requestArea])) {
            return self::$requestAreaOptions[$requestType][$requestArea];
        } else {
            return 'Not Found';
        }
    }


    public function setRequestTypeAttribute($value)
    {
        $allowedTypes = ['support', 'access'];
        $this->attributes['request_type'] = in_array(strtolower($value), $allowedTypes) ? strtolower($value) : 'support';
    }

    public function setPriorityAttribute($value)
    {
        $allowedPriorities = ['low', 'medium', 'high'];
        $this->attributes['priority'] = in_array(strtolower($value), $allowedPriorities) ? strtolower($value) : 'low';
    }

    public function setSatisfactionScoreAttribute($value)
    {
        $this->attributes['satisfaction_score'] = ($value >= 0 && $value <= 5) ? (float)$value : null;
    }

    public function setStatusAttribute($value)
    {
        $allowedStatuses = ['open', 'closed', 'in-progress'];
        $this->attributes['status'] = in_array(strtolower($value), $allowedStatuses) ? strtolower($value) : 'open';
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
