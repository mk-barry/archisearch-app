<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AuditsLogs extends Model
{
    protected $table = "audit_logs";
    protected $fillable = [
        'user_id',
        'event_id',
        'action',
        'details',
        'ip_address'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Events::class);
    }
}