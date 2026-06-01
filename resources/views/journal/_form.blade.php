@php
    $isEdit = isset($entry) && $entry;
    $action = $isEdit ? route('journal.update', $entry) : route('journal.store');
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
               value="{{ old('title', $entry?->title ?? '') }}" required placeholder="Give your entry a title">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="entry_date" class="form-label">Date</label>
            <input type="date" class="form-control @error('entry_date') is-invalid @enderror" id="entry_date" name="entry_date"
                   value="{{ old('entry_date', $entry?->entry_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
            @error('entry_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label d-block">How are you feeling?</label>
            <div class="mood-selector">
                @foreach (\App\Enums\Mood::cases() as $mood)
                    <input type="radio" name="mood" id="mood_{{ $mood->value }}" value="{{ $mood->value }}"
                           {{ old('mood', $entry?->mood?->value ?? 'neutral') === $mood->value ? 'checked' : '' }} required>
                    <label for="mood_{{ $mood->value }}">{{ $mood->emoji() }} {{ $mood->label() }}</label>
                @endforeach
            </div>
            @error('mood')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="content" class="form-label">Your thoughts</label>
        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                  required placeholder="Write freely about your day...">{{ old('content', $entry?->content ?? '') }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex flex-wrap gap-2">
        <button type="submit" class="btn-dj-primary" style="width: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
            {{ $isEdit ? 'Update Entry' : 'Save Entry' }}
        </button>
        <a href="{{ $isEdit ? route('journal.show', $entry) : route('journal.index') }}" class="btn-dj-secondary" style="width: auto; padding-left: 1.25rem; padding-right: 1.25rem;">Cancel</a>
    </div>
</form>
