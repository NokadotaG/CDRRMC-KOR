@extends("Layout.main")
@section("title", "Add Sensors")

@section("content")
<div class="container">
    <div class="header">
        <h1 class="fw-bold text-left">Add Sensor</h1>
        <p class="text-muted text-left mb-4">Fill out the details below to register a new sensor in the system.</p>
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

                    <!-- Form -->
                    <form method="POST" action="{{ route('sensors.store') }}" id="sensorForm">
                        @csrf

                        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label for="sensor_name">Sensor Name</label>
                                <input type="text" id="sensor_name" name="sensor_name" placeholder="Enter sensor name" required>
                                @error('sensor_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="sensor_type">Sensor Type</label>
                                <input type="text" id="sensor_type" name="sensor_type" placeholder="e.g. Rain Gauge, Water Level" required>
                                @error('sensor_type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="sensor_location">Sensor Location</label>
                                <input type="text" id="sensor_location" name="sensor_location" placeholder="Enter location" required>
                                @error('sensor_location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="sensor_status">Sensor Status</label>
                                <select id="sensor_status" name="sensor_status" required>
                                    <option value="" disabled selected>Select status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Under Maintenance">Under Maintenance</option>
                                </select>
                                @error('sensor_status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-buttons mt-4">
                            <button type="submit" class="btn-submit">Add Sensor</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel? Unsaved data will be lost.')) window.location='{{ route('sensors.index') }}';">
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
