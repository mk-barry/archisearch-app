<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organisation',
        'role',
        'documents_count',
        'last_login_at',
        'last_logout_at',
        'last_seen_at',
        'must_change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'last_logout_at' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    public function getStatusAttribute()
    {
        // 1. Est-il actif en ce moment ? (moins de 2 minutes d'inactivité)
        if ($this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(1))) {
            return '<span class="text-success badge-green">En ligne</span>';
        }

        // 2. Sinon, on affiche quand il a été vu pour la dernière fois
        if ($this->last_seen_at) {
            return '<span class="text-warning badge-orange">Vu ' . $this->last_seen_at->locale('fr')->diffForHumans() . '</span>';
        }

        // 3. S'il n'y a vraiment aucune trace
        return '<span class="text-danger badge-red">Jamais</span>';
    }

    public function events() {
        return $this->hasMany(Events::class);
    }
    
    public function logs() {
        return $this->hasMany(AuditsLogs::class);
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'processed_by', 'id');
    }
}
