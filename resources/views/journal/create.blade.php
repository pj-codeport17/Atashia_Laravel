@extends('layouts.app')

@section('title', 'New Entry - Daily Journal')

@section('content')
<div class="page-header mb-4">
    <h1>New Entry</h1>
    <p>Capture today's thoughts and how you're feeling</p>
</div>

<div class="chart-card">
    @include('journal._form', ['entry' => null])
</div>
@endsection
