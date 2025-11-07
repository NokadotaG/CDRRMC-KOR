@extends("Layout.main")
@section("title","View Alert")
@section("content")
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">Alert Details</h1>
        <p class="text-muted">Review the information below for this alert.</p>
    </div>

    <div class="card1 shadow-sm p-4">

        {{-- Alert Card --}}
        <div class="card mb-3 p-3">
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p><strong>Location:</strong> {{ $alert->location }}</p>

                    @php
                        $color = match($alert->status) {
                            'Low' => 'badge bg-warning text-dark',
                            'Moderate' => 'badge bg-orange text-white',
                            'High Risk' => 'badge bg-danger',
                            default => 'badge bg-secondary',
                        };
                    @endphp

                    <p><strong>Status:</strong> <span class="{{ $color }}">{{ $alert->status }}</span></p>
                </div>

                <div>
                    <p><strong>Triggered By:</strong> {{ $alert->triggered_by }}</p>
                    <p><strong>Notes:</strong> {{ $alert->notes ?: '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="form-buttons mt-3" style="display: flex; gap: 10px;">
            <a href="{{ route('alerts.index') }}" class="btn btn-secondary" style="padding: 8px 40px;">Back</a>
            <a href="{{ route('alerts.edit', $alert->id) }}" class="btn btn-primary" style="padding: 8px 40px;">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>

    </div>
</div>

<style>
    .bg-orange { background-color: #ff7f0e !important; }
    .badge { font-size: 0.9rem; padding: 0.4em 0.6em; }
</style>
@endsection
