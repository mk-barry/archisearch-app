<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Events extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'uuid',
        'mode',
        'status',
        'required_documents',
        'expires_at'
    ];

    // Conversion automatique du JSON en tableau PHP
    protected $casts = [
        'required_documents' => 'array',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Documents::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitations::class);
    }
}
