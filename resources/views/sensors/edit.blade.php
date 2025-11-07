@extends('Layout.main')

@section('title', 'Edit Sensor')

@section('content')
<div class="container">
    <div class="header text-left mb-4">
        <h1 class="fw-bold">Edit Sensor</h1>
        <p class="text-muted">Update the details below to modify sensor information.</p>
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

                    <!-- Edit Sensor Form -->
                    <form method="POST" action="{{ route('sensors.update', $sensors->id) }}" id="sensorForm">
                        @csrf
                        @method('PUT')

                        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <!-- Sensor Name -->
                            <div class="form-group">
                                <label>Sensor Name</label>
                                <input type="text" name="sensor_name" value="{{ old('sensor_name', $sensors->sensor_name) }}" required>
                                @error('sensor_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Sensor Type -->
                            <div class="form-group">
                                <label>Sensor Type</label>
                                <input type="text" name="sensor_type" value="{{ old('sensor_type', $sensors->sensor_type) }}" required>
                                @error('sensor_type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Sensor Location -->
                            <div class="form-group">
                                <label>Sensor Location</label>
                                <input type="text" name="sensor_location" value="{{ old('sensor_location', $sensors->sensor_location) }}" required>
                                @error('sensor_location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Sensor Status -->
                            <div class="form-group">
                                <label>Sensor Status</label>
                                <select name="sensor_status" required>
                                    <option value="Active" {{ old('sensor_status', $sensors->sensor_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('sensor_status', $sensors->sensor_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Maintenance" {{ old('sensor_status', $sensors->sensor_status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('sensor_status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-buttons mt-4" style="display: flex; gap: 10px;">
                            <button type="submit" class="btn-submit">Save Changes</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel editing? Unsaved changes will be lost.')) window.location='{{ route('sensors.index') }}';">
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