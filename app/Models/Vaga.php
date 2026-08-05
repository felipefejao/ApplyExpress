<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vaga extends Model
{
    /** @use HasFactory<\Database\Factories\VagaFactory> */
    use HasFactory;

    protected $table = 'vagas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'empresa',
        'email',
        'recrutador',
        'cargo',
        'slug',
        'enviado',
        'language',
        'relocation',
        'relocation_city',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'enviado' => 'boolean',
            'relocation' => 'boolean',
            'is_public' => 'boolean',
            'slug' => 'array',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $vaga): void {
            if (empty($vaga->slug)) {
                $vaga->slug = [$vaga->generateSlug()];
            }
        });

        static::updating(function (self $vaga): void {
            if ($vaga->isDirty('cargo') && ! $vaga->isDirty('slug')) {
                $vaga->slug = [$vaga->generateSlug()];
            }
        });
    }

    public function generateSlug(): string
    {
        $base = Str::slug($this->cargo ?: 'vaga');
        $slug = $base;
        $counter = 1;

        // Since slug is now an array, we check if the new slug exists within any record's slug array
        while (self::whereJsonContains('slug', $slug)->when($this->exists, fn ($query) => $query->where('id', '!=', $this->id))->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, ?User $user = null)
    {
        $user ??= auth()->user();

        if (! $user) {
            return $query->where('is_public', true);
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isCandidato()) {
            return $query->where('user_id', $user->id);
        }

        return $query->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('is_public', true);
        });
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
