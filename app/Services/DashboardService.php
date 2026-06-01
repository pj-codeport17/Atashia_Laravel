<?php

namespace App\Services;

use App\Enums\Mood;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /** @return array<string, mixed> */
    public function stats(User $user): array
    {
        $entriesByMonth = $user->journalEntries()
            ->where('entry_date', '>=', now()->subMonths(5)->startOfMonth())
            ->get()
            ->groupBy(fn ($entry) => $entry->entry_date->format('Y-m'))
            ->map->count();

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $months->put($key, $entriesByMonth->get($key, 0));
        }

        $moodCounts = $user->journalEntries()
            ->select('mood', DB::raw('count(*) as total'))
            ->groupBy('mood')
            ->pluck('total', 'mood');

        return [
            'totalEntries' => $user->journalEntries()->count(),
            'thisMonthEntries' => $user->journalEntries()
                ->whereMonth('entry_date', now()->month)
                ->whereYear('entry_date', now()->year)
                ->count(),
            'streakDays' => $this->writingStreak($user->id),
            'months' => $months,
            'monthLabels' => $months->keys()
                ->map(fn (string $month) => Carbon::createFromFormat('Y-m', $month)->format('M Y'))
                ->values(),
            'moodChart' => collect(Mood::cases())->map(fn (Mood $mood) => [
                'label' => $mood->label(),
                'count' => (int) $moodCounts->get($mood->value, 0),
                'color' => $mood->color(),
            ]),
            'recentEntries' => $user->journalEntries()
                ->latest('entry_date')
                ->latest('id')
                ->limit(5)
                ->get(),
        ];
    }

    private function writingStreak(int $userId): int
    {
        $dates = DB::table('journal_entries')
            ->where('user_id', $userId)
            ->distinct()
            ->orderByDesc('entry_date')
            ->pluck('entry_date')
            ->map(fn ($d) => Carbon::parse($d)->startOfDay());

        if ($dates->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $expected = now()->startOfDay();

        if (! $dates->first()->equalTo($expected) && ! $dates->first()->equalTo($expected->copy()->subDay())) {
            return 0;
        }

        if ($dates->first()->equalTo($expected->copy()->subDay())) {
            $expected = $expected->subDay();
        }

        foreach ($dates as $date) {
            if ($date->equalTo($expected)) {
                $streak++;
                $expected = $expected->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}
