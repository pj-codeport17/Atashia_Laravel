<?php

namespace App\Policies;

use App\Models\JournalEntry;
use App\Models\User;

class JournalEntryPolicy
{
    public function view(User $user, JournalEntry $journal): bool
    {
        return $journal->user_id === $user->id;
    }

    public function update(User $user, JournalEntry $journal): bool
    {
        return $journal->user_id === $user->id;
    }

    public function delete(User $user, JournalEntry $journal): bool
    {
        return $journal->user_id === $user->id;
    }
}
