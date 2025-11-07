@extends('layout.main')

@section('title', 'View Task')

@section('content')
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">Task Details</h1>
        <p class="text-muted">Review the details of this task below.</p>
    </div>

    <div class="card1 shadow-sm p-4">

        {{-- Task Details Card --}}
        <div class="card mb-3 p-3">
            <h4 class="fw-bold mb-3">{{ $task->title }}</h4>

            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p><strong>Description:</strong> {{ $task->description ?? 'No description' }}</p>
                    <p><strong>Location:</strong> {{ $task->location }}</p>
                    <p><strong>Due Date & Time:</strong> 
                        {{ $task->due_datetime ? $task->due_datetime->format('Y-m-d h:i A') : '-' }}
                    </p>
                </div>

                <div>
                    <p><strong>Responder:</strong> 
                        {{ $task->responder?->res_fname }} {{ $task->responder?->res_lname ?? '-' }}
                    </p>
                    <p><strong>Email:</strong> {{ $task->responder?->res_email ?? '-' }}</p>
                    <p><strong>Contact:</strong> {{ $task->responder?->res_contact ?? '-' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($task->status === 'pending') bg-warning text-dark
                            @elseif($task->status === 'ongoing') bg-info text-white
                            @else bg-success
                            @endif">
                            {{ ucfirst($task->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="form-buttons mt-3" style="display: flex; gap: 10px;">
            <button type="button" class="btn btn-secondary" style="padding: 8px 40px;"
                onclick="if(confirm('Are you sure you want to go back?')) window.history.back();">
                Back
            </button>
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary" style="padding: 8px 40px;">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>

    </div>
</div>

<style>
    .badge { font-size: 0.9rem; padding: 0.4em 0.6em; }
</style>
@endsection
