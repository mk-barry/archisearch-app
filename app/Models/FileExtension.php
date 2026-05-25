<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileExtension extends Model
{
    protected $fillable = ['name', 'mime_type']; // Important pour le store()

    public function documentTypes()
    {
        return $this->belongsToMany(DocumentType::class, 'document_type_extension');
    }

    // public function documents()
    // {
    //     return $this->hasMany(Documents::class, 'file_type');
    // }
}
