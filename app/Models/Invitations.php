<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{
    protected $fillable = ['event_id', 'email', 'token', 'expires_at', 'used_at'];

    protected $casts = ['expires_at' => 'datetime', 'used_at' => 'datetime'];

    public function event()
    {
        return $this->belongsTo(Events::class);
    }
}
