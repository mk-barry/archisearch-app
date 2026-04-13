<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionDescription extends Model
{
    protected $fillable = ['title', 'description'];

    public function logs()
    {
        return $this->hasMany(AuditsLogs::class);
    }
}