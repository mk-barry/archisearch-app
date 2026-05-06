<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Expr\Cast;


class AuditLog extends Model
{
    protected $table = "audit_logs";
    protected $fillable = [
        'user_id',
        'action_description_id',
        'dynamic_data',
        'ip_address'
    ];
    
    protected $casts= [
        'dynamic_data' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function actionDescription(): BelongsTo
    {
        return $this->belongsTo(ActionDescription::class);
    }

    public static function log($slug, $data = [])
    {
        $action = ActionDescription::where('slug', $slug)->first();

        if (!$action) {
            return;
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action_description_id' => $action->id,
            'dynamic_data' => $data,
            'ip_address' => request()->ip(),
            'name' => auth()->user()->name,
        ]);
    }

    public function getMessageAttribute()
    {
        if (!$this->actionDescription) {
            return '';
        }

        $message = $this->actionDescription->template;

        $data = $this->dynamic_data ?? [];

        foreach ($data as $key => $value) {
            $message = str_replace(":$key", $value, $message);
        }

        return $message;
    }
}