<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDocumentType extends Model
{
    protected $table = 'event_document_type';

    protected $fillable = [
        'event_id',
        'document_type_id',
    ];

}
