@extends("Layout.main")
@section("title", "Add Alert")

@section("content")
<div class="container">
    <div class="header">
        <h1 class="fw-bold text-left">Add Alert</h1>
        <p class="text-muted text-left mb-4">Fill out the form below to create a new alert record.</p>
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

                    <!-- Alert Form -->
                    <form action="{{ route('alerts.store') }}" method="POST">
                        @csrf

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" placeholder="Enter alert location" required>
                                @error('location') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Alert Status</label>
                                <select id="status" name="status" required>
                                    <option value="" disabled selected>Select status</option>
                                    <option value="Low">Low</option>
                                    <option value="Moderate">Moderate</option>
                                    <option value="High">High</option>
                                </select>
                                @error('status') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="triggered_by">Triggered By</label>
                                <select id="triggered_by" name="triggered_by" required>
                                    <option value="Monitoring Device" selected>Monitoring Device</option>
                                    <option value="Admin">Admin</option>
                                </select>
                                @error('triggered_by') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group" style="grid-column: span 2;">
                                <label for="notes">Notes</label>
                                <textarea id="notes" name="notes" placeholder="Enter any notes or remarks (optional)" rows="4"></textarea>
                                @error('notes') <span>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn-submit">Save Alert</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel? Unsaved data will be lost.')) window.location='{{ route('alerts.index') }}';">
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
