@extends('layouts.app')

@section('title', 'My Entries - Daily Journal')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <h1>My Entries</h1>
        <p>Browse and manage your journal entries</p>
    </div>
    <a href="{{ route('journal.create') }}" class="btn-dj-primary" style="width: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
        <i class="bi bi-plus-lg me-1"></i> New Entry
    </a>
</div>

<div class="filter-card">
    <form method="GET" action="{{ route('journal.index') }}" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search title or content..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Mood</label>
            <select name="mood" class="form-select">
                <option value="">All moods</option>
                @foreach (\App\Enums\Mood::cases() as $mood)
                    <option value="{{ $mood->value }}" {{ request('mood') === $mood->value ? 'selected' : '' }}>
                        {{ $mood->emoji() }} {{ $mood->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn-dj-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
        </div>
    </form>
</div>

<div class="row g-4">
    @forelse ($entries as $entry)
        <div class="col-md-6 col-lg-4">
            <div class="journal-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="fs-4">{{ $entry->moodEmoji() }}</span>
                        <span class="entry-date">{{ $entry->entry_date->format('M d, Y') }}</span>
                    </div>
                    <h3 class="entry-title">
                        <a href="{{ route('journal.show', $entry) }}" class="text-decoration-none text-dark">{{ $entry->title }}</a>
                    </h3>
                    <p class="entry-excerpt">{{ $entry->content }}</p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('journal.show', $entry) }}" class="btn-dj-outline btn-sm py-1 px-3">Read</a>
                        <a href="{{ route('journal.edit', $entry) }}" class="btn btn-sm btn-light rounded-pill px-3">Edit</a>
                        <form action="{{ route('journal.destroy', $entry) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="chart-card empty-state">
                <i class="bi bi-journal-x d-block"></i>
                <p class="text-muted mt-3 mb-3">No journal entries found.</p>
                <a href="{{ route('journal.create') }}" class="btn-dj-primary" style="width: auto; display: inline-flex;">Create Your First Entry</a>
            </div>
        </div>
    @endforelse
</div>

@if ($entries->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $entries->links() }}
    </div>
@endif
@endsection
