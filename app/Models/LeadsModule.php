<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadsModule extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'leads_modules';

    protected $dates = [
        'last_call_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'new'             => 'New',
        'in_progress'     => 'In Progress',
        'converted'       => 'Converted',
        'not _interested' => 'Not Interested',
        'callback'        => 'Callback',
    ];

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'status',
        'assigned_to_id',
        'notes',
        'remarks_by_telecaller',
        'last_call_date',
        'service_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function assigned_to()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function getLastCallDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setLastCallDateAttribute($value)
    {
        $this->attributes['last_call_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
     public function users()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
