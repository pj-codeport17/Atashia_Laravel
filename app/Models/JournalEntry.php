<?php

namespace App\Models;

use App\Enums\Mood;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalEntry extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'mood',
        'entry_date',
    ];

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'mood' => Mood::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%");
        });
    }

    public function moodLabel(): string
    {
        return $this->mood?->label() ?? Mood::Neutral->label();
    }

    public function moodEmoji(): string
    {
        return $this->mood?->emoji() ?? Mood::Neutral->emoji();
    }

    public function moodColor(): string
    {
        return $this->mood?->color() ?? Mood::Neutral->color();
    }
}
