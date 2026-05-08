<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Events extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'uuid', // Doit être fillable
        'start_date', // Manquait
        'end_date',   // Manquait
        'invite_type',
        'status',
        'required_docs',
        'max_file_size', // Manquait
        'expires_at'
    ];

    protected $casts = [
        'required_docs' => 'array',
        'expires_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Génération automatique du UUID à la création
    protected static function booted()
    {
        static::creating(function ($event) {
            $event->uuid = (string) Str::uuid();
        });
    }

    public function getSubmissionsCountAttribute()
    {
        // On compte les matricules (identifier) uniques qui ont déposé des documents pour cet event
        return \DB::table('documents')
            ->where('event_id', $this->id)
            ->distinct('identifier')
            ->count();
    }

    public function getTotalExpectedAttribute()
    {
        if ($this->invite_type === 'tous') {
            // Nombre total d'étudiants dans ton référentiel
            return \App\Models\AuthorizedStudent::count();
        }

        // Nombre d'étudiants spécifiques liés via la table pivot
        return $this->authorizedStudents()->count();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function AuthorizedStudents()
    {
        return $this->belongsToMany(AuthorizedStudent::class, 'event_authorized_student', 'event_id', 'authorized_student_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Documents::class, 'event_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitations::class);
    }
}
