<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
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
        'linkedin',
        'github',
        'phone',
        'bio',
        'locale',
        'is_admin',
        'role',
        'credits',
        'application_text',
        'cover_letter',
        'default_curriculo_id',
    ];

    const ROLE_SUPER_ADMIN = 'super-admin';
    const ROLE_CANDIDATO = 'candidato';
    const ROLE_EMPRESA = 'empresa';

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN || $this->is_admin;
    }

    public function isCandidato(): bool
    {
        return $this->role === self::ROLE_CANDIDATO;
    }

    public function isEmpresa(): bool
    {
        return $this->role === self::ROLE_EMPRESA;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'is_admin' => 'boolean',
            'credits' => 'integer',
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->whereIn('status', ['active', 'trialing'])
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->latest('starts_at');
    }

    public function vagas()
    {
        return $this->hasMany(Vaga::class);
    }

    public function curriculos()
    {
        return $this->hasMany(Curriculo::class);
    }

    public function defaultCurriculo()
    {
        return $this->belongsTo(Curriculo::class, 'default_curriculo_id');
    }
}
