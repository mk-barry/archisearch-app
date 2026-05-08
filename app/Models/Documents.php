<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documents extends Model
{
    protected $fillable = [
        'event_id',
        'identifier',
        'tracking_code',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Events::class);
    }

    // Relation optionnelle vers l'étudiant autorisé (en mode strict)
    public function student()
    {
        return $this->belongsTo(AuthorizedStudent::class, 'identifier', 'matricule');
    }
}