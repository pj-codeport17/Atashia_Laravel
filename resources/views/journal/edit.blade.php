@extends('layouts.app')

@section('title', 'Edit Entry - Daily Journal')

@section('content')
<div class="page-header mb-4">
    <h1>Edit Entry</h1>
    <p>Update your journal entry</p>
</div>

<div class="chart-card">
    @include('journal._form', ['entry' => $entry])
</div>
@endsection
