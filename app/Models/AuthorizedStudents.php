<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizedStudents extends Model
{
    protected $fillable = ['matricule', 'full_name', 'email', 'class_level'];

    // Un étudiant peut avoir plusieurs documents déposés (si l'événement le permet)
    public function documents()
    {
        return $this->hasMany(Documents::class, 'identifier', 'matricule');
    }
}