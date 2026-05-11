<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['slug', 'label'];

    public function events()
    {
        return $this->belongsToMany(
            Events::class,
            'event_document_type'
        );
    }

    public function extensions()
    {
        return $this->hasMany(DocumentExtension::class);
    }
}
