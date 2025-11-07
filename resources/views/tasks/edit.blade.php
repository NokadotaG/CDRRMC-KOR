@extends('layout.main')

@section('title', 'Edit Task')

@section('content')
<div class="container">
    <div class="header text-left mb-4">
        <h1 class="fw-bold">Edit Task</h1>
        <p class="text-muted">Modify the details below to update this task.</p>
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

                    <!-- Edit Task Form -->
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" id="title" name="title" 
                                       value="{{ old('title', $task->title) }}" 
                                       placeholder="Enter task title" required>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Location -->
                            <div class="form-group">
                                <label for="location">Location of Reported Area</label>
                                <input type="text" id="location" name="location" 
                                       value="{{ old('location', $task->location) }}" 
                                       placeholder="Enter affected area" required>
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Responder -->
                            <div class="form-group">
                                <label for="responder_id">Assign to Responder</label>
                                <select id="responder_id" name="responder_id" required>
                                    <option value="">Select Responder</option>
                                    @foreach($responders as $responder)
                                        <option value="{{ $responder->id }}" 
                                            {{ old('responder_id', $task->responder_id) == $responder->id ? 'selected' : '' }}>
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
                                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ongoing" {{ old('status', $task->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Due Date & Time -->
                            <div class="form-group">
                                <label for="due_datetime">Due Date & Time</label>
                                <input type="datetime-local" id="due_datetime" name="due_datetime"
                                       value="{{ old('due_datetime', optional($task->due_datetime)->format('Y-m-d\TH:i')) }}"
                                       class="date">
                                @error('due_datetime') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description (Bottom Full Width) -->
                            <div class="form-group" style="grid-column: span 3;">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="8" 
                                          placeholder="Provide additional details (optional)">{{ old('description', $task->description) }}</textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-buttons mt-4">
                            <button type="submit" class="btn-submit">Save Changes</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel editing? Unsaved changes will be lost.')) window.location='{{ route('tasks.index') }}';">
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
