@extends('layouts.app')

@section('title', 'Dashboard - Daily Journal')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <h1>Dashboard</h1>
        <p>Your journaling insights at a glance</p>
    </div>
    <a href="{{ route('journal.create') }}" class="btn-dj-primary" style="width: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
        <i class="bi bi-plus-lg me-1"></i> New Entry
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div class="stat-value">{{ $totalEntries }}</div>
            <div class="stat-label">Total Entries</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(74, 144, 217, 0.12); color: var(--dj-icon-blue);"><i class="bi bi-calendar-month"></i></div>
            <div class="stat-value">{{ $thisMonthEntries }}</div>
            <div class="stat-label">Entries This Month</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(95, 158, 160, 0.2);"><i class="bi bi-fire"></i></div>
            <div class="stat-value">{{ $streakDays }}</div>
            <div class="stat-label">Day Writing Streak</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="chart-card">
            <h5>Entries Over Time</h5>
            <canvas id="entriesChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="chart-card">
            <h5>Mood Distribution</h5>
            <canvas id="moodChart" height="200"></canvas>
        </div>
    </div>
</div>

<div class="chart-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-semibold">Recent Entries</h5>
        <a href="{{ route('journal.index') }}" class="btn-dj-outline btn-sm">View All</a>
    </div>

    @forelse ($recentEntries as $entry)
        <div class="d-flex align-items-start gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
            <span class="fs-4">{{ $entry->moodEmoji() }}</span>
            <div class="flex-grow-1">
                <a href="{{ route('journal.show', $entry) }}" class="text-decoration-none text-dark fw-semibold">{{ $entry->title }}</a>
                <div class="text-muted small">{{ $entry->entry_date->format('M d, Y') }} · {{ $entry->moodLabel() }}</div>
                <p class="text-muted small mb-0 mt-1">{{ Str::limit($entry->content, 100) }}</p>
            </div>
        </div>
    @empty
        <div class="empty-state py-4">
            <i class="bi bi-journal-plus d-block mb-2"></i>
            <p class="text-muted mb-3">No entries yet.</p>
            <a href="{{ route('journal.create') }}" class="btn-dj-primary" style="width: auto; display: inline-flex;">Write your first entry</a>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const monthLabels = @json($monthLabels);
    const monthData = @json($months->values());

    new Chart(document.getElementById('entriesChart'), {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Entries',
                data: monthData,
                borderColor: '#5f9ea0',
                backgroundColor: 'rgba(95, 158, 160, 0.15)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#5f9ea0',
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    const moodLabels = @json($moodChart->pluck('label'));
    const moodData = @json($moodChart->pluck('count'));
    const moodColors = @json($moodChart->pluck('color'));

    new Chart(document.getElementById('moodChart'), {
        type: 'doughnut',
        data: {
            labels: moodLabels,
            datasets: [{
                data: moodData,
                backgroundColor: moodColors,
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
