<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['code', 'label', 'validation_rules', 'max_size_kb', 'is_perishable'];

    protected $casts = [
        // 'allowed_extensions' => 'array', // Transforme le JSON en tableau PHP
        'validation_rules' => 'array', // Transforme le JSON en tableau PHP
        'is_perishable' => 'boolean',
    ];

    public function events()
    {
        return $this->belongsToMany(
            Events::class,
            'event_document_type'
        );
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'document_type_id');
    }
    
    public function allowedExtensions()
    {
        return $this->belongsToMany(FileExtension::class, 'document_type_extension');
    }

    // Pour récupérer les noms sous forme de tableau : 
    // $extensions = $docType->allowedExtensions()->pluck('name')->toArray();
}
