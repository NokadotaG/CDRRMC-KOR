@extends('Layout.main')

@section('title','View Sensor')

@section('content')
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">Sensor Details</h1>
        <p class="text-muted">Review the information below for this sensor.</p>
    </div>

    <div class="card1 shadow-sm p-4">
        {{-- Sensor Details --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p><strong>Sensor ID:</strong> {{ $sensors->id }}</p>
                        <p><strong>Sensor Name:</strong> {{ $sensors->sensor_name }}</p>
                        <p><strong>Sensor Type:</strong> {{ $sensors->sensor_type }}</p>
                    </div>
                    <div>
                        <p><strong>Sensor Location:</strong> {{ $sensors->sensor_location }}</p>
                        <p><strong>Sensor Status:</strong> {{ $sensors->sensor_status }}</p>
                        <p><strong>Created At:</strong> {{ $sensors->created_at->format('Y-m-d H:i') }}</p>
                        <p><strong>Updated At:</strong> {{ $sensors->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="form-buttons mt-3" style="display: flex; gap: 10px; align-items: center;">
            <button type="button" class="btn btn-secondary" onclick="window.history.back();" style="padding: 8px 40px; border-radius: 7px;">
                Back
            </button>
            <a href="{{ route('sensors.edit', $sensors->id) }}" class="btn btn-warning btn-sm me-1" style="padding: 9px 30px; border-radius: 7px;">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection