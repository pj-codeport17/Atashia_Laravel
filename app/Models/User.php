<?php

namespace App\Models;

use App\Enums\Gender;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'profile_picture',
        'phone',
        'gender',
        'date_of_birth',
        'bio',
        'address',
        'city',
        'country',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'gender' => Gender::class,
            'is_admin' => 'boolean',
        ];
    }

    public function profilePictureUrl(): ?string
    {
        if (! $this->profile_picture) {
            return null;
        }

        return asset('storage/'.$this->profile_picture);
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim($this->name));

        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1).substr(end($parts), 0, 1));
        }

        return strtoupper(substr($this->name, 0, 1));
    }

    public function genderLabel(): ?string
    {
        return $this->gender?->label();
    }

    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }
}
