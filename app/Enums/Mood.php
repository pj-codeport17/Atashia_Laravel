<?php

namespace App\Enums;

enum Mood: string
{
    case Happy = 'happy';
    case Calm = 'calm';
    case Neutral = 'neutral';
    case Sad = 'sad';
    case Anxious = 'anxious';
    case Excited = 'excited';

    public function label(): string
    {
        return match ($this) {
            self::Happy => 'Happy',
            self::Calm => 'Calm',
            self::Neutral => 'Neutral',
            self::Sad => 'Sad',
            self::Anxious => 'Anxious',
            self::Excited => 'Excited',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::Happy => '😊',
            self::Calm => '😌',
            self::Neutral => '😐',
            self::Sad => '😢',
            self::Anxious => '😰',
            self::Excited => '🤩',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Happy => '#F59E0B',
            self::Calm => '#10B981',
            self::Neutral => '#6B7280',
            self::Sad => '#3B82F6',
            self::Anxious => '#8B5CF6',
            self::Excited => '#EC4899',
        };
    }

    public static function tryFromString(?string $value): ?self
    {
        return $value ? self::tryFrom($value) : null;
    }

    /** @return list<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
