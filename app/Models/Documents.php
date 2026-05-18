<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documents extends Model
{
    protected $fillable = [
        'event_id',
        'document_type_id', // Assure-toi que cette colonne existe dans ta migration
        'identifier',
        'tracking_code',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'status',
        'metadata',
        'extracted_text',
        'rejection_reason',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Relation avec le type de document (Catégorie)
     */
    public function documentType(): BelongsTo
    {
        // On lie via 'document_type_id' ou 'category' selon ta structure
        // Si ta colonne s'appelle 'category' et contient l'ID :
        return $this->belongsTo(DocumentType::class, 'category');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Events::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(AuthorizedStudent::class, 'identifier', 'matricule');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Accesseur pour récupérer automatiquement la classe CSS du badge
     * Utilisation dans le Blade : {{ $doc->status_class }}
     */
    public function getStatusClassAttribute(): string
    {
        return match (strtolower($this->status)) {
            'accepté', 'valide' => 'badge-green',
            'en traitement', 'indexé', 'en attente' => 'badge-blue',
            'à revoir', 'incomplet' => 'badge-orange',
            'rejeté', 'refusé' => 'badge-red',
            default => 'badge-gray',
        };
    }

    /**
     * Accesseur pour l'extension simplifiée (pour les icônes)
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION) ?: 'file';
    }
}