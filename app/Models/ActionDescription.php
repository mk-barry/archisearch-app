<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActionDescription extends Model
{
    protected $table = "action_descriptions";
    protected $fillable = ['slug', 'title', 'template'];

    public function logs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}