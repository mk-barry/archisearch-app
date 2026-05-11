<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['slug', 'label'];

    protected $casts = [
        'allowed_extensions' => 'array', // Transforme le JSON en tableau PHP
    ];

    public function events()
    {
        return $this->belongsToMany(
            Events::class,
            'event_document_type'
        );
    }
    
    public function allowedExtensions()
    {
        return $this->belongsToMany(FileExtension::class, 'document_type_extension');
    }

    // Pour récupérer les noms sous forme de tableau : 
    // $extensions = $docType->allowedExtensions()->pluck('name')->toArray();
}
