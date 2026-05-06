<?php

namespace App\Helpers;

use App\Models\AuditLog;
use App\Models\ActionDescription;
use Illuminate\Support\Facades\Auth;

class Audit
{
    public static function log(string $slug, array $data = [])
    {
        $action = ActionDescription::where('slug', $slug)->first();

        if (!$action)
            return;

        AuditLog::create([
            'user_id' => Auth::id(),
            'action_description_id' => $action->id,
            'dynamic_data' => $data,
            'ip_address' => request()->ip(),
        ]);
    }
}