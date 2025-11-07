@extends('layout.main')

@section('title', 'Create Task')

@section('content')
<div class="container">
    <div class="header text-left mb-4">
        <h1 class="fw-bold">Create New Task</h1>
        <p class="text-muted">Fill out the details below to assign a new task to a responder.</p>
    </div>

    <div class="card1 shadow-sm">

        <div class="table">
            <div class="table_section">
                <div class="card p-4">

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>⚠️ Please fix the following errors:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Task Form -->
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <div class="form-grid">
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" id="title" name="title" placeholder="Enter task title" required>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Location -->
                            <div class="form-group">
                                <label for="location">Location of Reported Area</label>
                                <input type="text" id="location" name="location" placeholder="Enter affected area" required>
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Responder -->
                            <div class="form-group">
                                <label for="responder_id">Assign to Responder</label>
                                <select id="responder_id" name="responder_id" required>
                                    <option value="">Select Responder</option>
                                    @foreach($responders as $responder)
                                        <option value="{{ $responder->id }}">
                                            {{ $responder->res_fname }} {{ $responder->res_lname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('responder_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" required>
                                    <option value="pending" selected>Pending</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Due Date & Time -->
                            <div class="form-group">
                                <label for="due_datetime">Due Date & Time</label>
                                <input type="datetime-local" id="due_datetime" name="due_datetime" class="date">
                                @error('due_datetime') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description (Moved to Bottom) -->
                            <div class="form-group" style="grid-column: span 3;">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" placeholder=" Provide additional details (optional)" rows="8"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-buttons mt-4">
                            <button type="submit" class="btn-submit">Create Task</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel? Unsaved data will be lost.')) window.location='{{ route('tasks.index') }}';">
                                Cancel
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
