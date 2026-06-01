<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\User;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@dailyjournal.test'],
            [
                'name' => 'Demo User',
                'password' => 'password',
            ]
        );

        $user->update([
            'phone' => '+1 (555) 123-4567',
            'gender' => Gender::PreferNotToSay,
            'date_of_birth' => '1995-06-15',
            'bio' => 'Passionate about mindfulness, writing, and capturing everyday moments.',
            'address' => '123 Journal Lane',
            'city' => 'San Francisco',
            'country' => 'United States',
        ]);

        if ($user->journalEntries()->exists()) {
            return;
        }

        $samples = [
            ['title' => 'A peaceful morning', 'content' => 'Woke up early and enjoyed coffee on the porch. The quiet start set a calm tone for the whole day.', 'mood' => 'calm', 'days_ago' => 0],
            ['title' => 'Project milestone', 'content' => 'Finally shipped the feature I have been working on for weeks. Team celebrated with lunch together.', 'mood' => 'excited', 'days_ago' => 1],
            ['title' => 'Rainy afternoon reflections', 'content' => 'Rain kept me indoors. Read a few chapters and journaled about goals for the month ahead.', 'mood' => 'happy', 'days_ago' => 2],
            ['title' => 'Tough conversation', 'content' => 'Had a difficult talk with a friend. Feeling drained but hopeful we can work through it.', 'mood' => 'sad', 'days_ago' => 3],
            ['title' => 'Weekend hike', 'content' => 'Explored the trail near the lake. Fresh air and movement cleared my head completely.', 'mood' => 'happy', 'days_ago' => 5],
            ['title' => 'Deadline stress', 'content' => 'Too many tasks piled up today. Need to prioritize better tomorrow morning.', 'mood' => 'anxious', 'days_ago' => 7],
            ['title' => 'Gratitude list', 'content' => 'Listed five things I am grateful for: health, family, music, sunshine, and this journal habit.', 'mood' => 'happy', 'days_ago' => 10],
            ['title' => 'Ordinary Tuesday', 'content' => 'Nothing extraordinary happened. Sometimes neutral days are exactly what I need.', 'mood' => 'neutral', 'days_ago' => 14],
        ];

        foreach ($samples as $sample) {
            $user->journalEntries()->create([
                'title' => $sample['title'],
                'content' => $sample['content'],
                'mood' => $sample['mood'],
                'entry_date' => now()->subDays($sample['days_ago'])->toDateString(),
            ]);
        }
    }
}
