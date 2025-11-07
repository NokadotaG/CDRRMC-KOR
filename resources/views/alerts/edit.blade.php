@extends('Layout.main')

@section('title', 'Edit Alert')

@section('content')
<div class="container">
    <div class="header text-left mb-4">
        <h1 class="fw-bold">Edit Alert</h1>
        <p class="text-muted">Update the details below to modify alert information.</p>
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

                    <!-- Edit Alert Form -->
                    <form action="{{ route('alerts.update', $alert->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-grid" style="display: flex; flex-direction: column; gap: 1.2rem;">

                            <!-- Location -->
                            <div class="form-group">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" name="location" value="{{ old('location', $alert->location) }}" 
                                    class="form-control" required>
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Low" {{ old('status', $alert->status) == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Moderate" {{ old('status', $alert->status) == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                    <option value="High Risk" {{ old('status', $alert->status) == 'High Risk' ? 'selected' : '' }}>High Risk</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Triggered By -->
                            <div class="form-group">
                                <label class="form-label fw-semibold">Triggered By</label>
                                <select name="triggered_by" class="form-select" required>
                                    <option value="Monitoring Device" {{ old('triggered_by', $alert->triggered_by) == 'Monitoring Device' ? 'selected' : '' }}>Monitoring Device</option>
                                    <option value="Admin" {{ old('triggered_by', $alert->triggered_by) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('triggered_by') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Notes -->
                            <div class="form-group">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes" class="form-control" rows="6">{{ old('notes', $alert->notes) }}</textarea>
                                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-buttons mt-4 d-flex gap-2">
                            <button type="submit" class="btn-submit">Save Changes</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel editing? Unsaved changes will be lost.')) window.location='{{ route('alerts.index') }}';">
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
