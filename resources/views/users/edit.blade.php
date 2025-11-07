@extends('Layout.main')

@section('title', 'Edit Responder')

@section('content')
<div class="container">
    <div class="header text-left mb-4">
        <h1 class="fw-bold">Edit Responder</h1>
        <p class="text-muted">Update the details below to modify responder information.</p>
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

                    <!-- Edit Form -->
                    <form action="{{ route('users.update', $responders->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <!-- First Name -->
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="res_fname" value="{{ old('res_fname', $responders->res_fname) }}" required>
                                @error('res_fname') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Middle Name -->
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" name="res_mname" value="{{ old('res_mname', $responders->res_mname) }}" required>
                                @error('res_mname') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="res_lname" value="{{ old('res_lname', $responders->res_lname) }}" required>
                                @error('res_lname') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Suffix -->
                            <div class="form-group">
                                <label>Suffix (optional)</label>
                                <input type="text" name="res_suffix" value="{{ old('res_suffix', $responders->res_suffix) }}">
                                @error('res_suffix') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Username -->
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="res_username" value="{{ old('res_username', $responders->res_username) }}" required>
                                @error('res_username') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="res_email" value="{{ old('res_email', $responders->res_email) }}" required>
                                @error('res_email') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label>New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                <input type="password" name="res_password" placeholder="Enter new password">
                                @error('res_password') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="res_password_confirmation" placeholder="Re-enter new password">
                                @error('res_password_confirmation') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Contact -->
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" name="res_contact" value="{{ old('res_contact', $responders->res_contact) }}" required>
                                @error('res_contact') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Work Position -->
                            <div class="form-group">
                                <label>Work Position</label>
                                <input type="text" name="res_position" value="{{ old('res_position', $responders->res_position) }}" required>
                                @error('res_position') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Work Company -->
                            <div class="form-group">
                                <label>Work Company</label>
                                <input type="text" name="res_company" value="{{ old('res_company', $responders->res_company) }}" required>
                                @error('res_company') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Company Address -->
                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" name="res_workadd" value="{{ old('res_workadd', $responders->res_workadd) }}" required>
                                @error('res_workadd') <span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Profile Image -->
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" name="res_image" accept="image/*">
                                @if($responders->res_image)
                                    <small class="text-muted d-block mt-1">Current: 
                                        <a href="{{ asset('storage/' . $responders->res_image) }}" target="_blank">View Image</a>
                                    </small>
                                @endif
                                @error('res_image') <span>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-buttons mt-4">
                            <button type="submit" class="btn-submit">Save Changes</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel editing? Unsaved changes will be lost.')) window.location='{{ route('users.index') }}';">
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
