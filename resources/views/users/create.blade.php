@extends("Layout.main")
@section("title", "Add Users")

@section("content")
<div class="container">
    <div class="header">
        <h1 class="fw-bold text-left">Add Responder</h1>
        <p class="text-muted text-left mb-4">Fill out the details below to register a new responder account.</p>
    </div>

    <div class="card1 shadow-sm">
        <!-- Back Button -->

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
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-grid">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="res_fname" placeholder="Enter first name" required>
                                @error('res_fname') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" name="res_mname" placeholder="Enter middle name" required>
                                @error('res_mname') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="res_lname" placeholder="Enter last name" required>
                                @error('res_lname') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Suffix (optional)</label>
                                <input type="text" name="res_suffix" placeholder="e.g. Jr., III">
                                @error('res_suffix') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="res_username" placeholder="Enter username">
                                @error('res_username') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="res_email" placeholder="example@email.com" required>
                                @error('res_email') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="res_password" placeholder="Enter password" required>
                                @error('res_password') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="res_password_confirmation" placeholder="Re-enter password" required>
                                @error('res_password_confirmation') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" name="res_contact" placeholder="09XXXXXXXXX" required>
                                @error('res_contact') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Work Position</label>
                                <input type="text" name="res_position" placeholder="Enter work position" required>
                                @error('res_position') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Work Company</label>
                                <input type="text" name="res_company" placeholder="Enter company name" required>
                                @error('res_company') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" name="res_workadd" placeholder="Enter company address" required>
                                @error('res_workadd') <span>{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" name="res_image" accept="image/*">
                                @error('res_image') <span>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn-submit">Create User</button>
                            <button type="button" class="btn-cancel"
                                onclick="if(confirm('Are you sure you want to cancel? Unsaved data will be lost.')) window.location='{{ route('users.index') }}';">
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
