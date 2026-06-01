@extends('layouts.app')

@section('title', $entry->title . ' - Daily Journal')

@section('content')
<div class="page-header mb-4">
    <a href="{{ route('journal.index') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left"></i> Back to entries
    </a>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mt-2">
        <div>
            <h1>{{ $entry->title }}</h1>
            <p class="mb-0">
                <span class="fs-5">{{ $entry->moodEmoji() }}</span>
                {{ $entry->moodLabel() }} · {{ $entry->entry_date->format('l, F j, Y') }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('journal.edit', $entry) }}" class="btn-dj-outline">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('journal.destroy', $entry) }}" method="POST" onsubmit="return confirm('Delete this entry permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="entry-detail">
    <div class="entry-content">{{ $entry->content }}</div>
    <hr class="my-4">
    <small class="text-muted">
        Created {{ $entry->created_at->diffForHumans() }}
        @if ($entry->updated_at->ne($entry->created_at))
            · Updated {{ $entry->updated_at->diffForHumans() }}
        @endif
    </small>
</div>
@endsection
