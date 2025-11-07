@extends("Layout.main")
@section("title","Users")

@section("content")
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">USERS</h1>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body">
            {{-- ======= TOP CONTROLS ======= --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">

                {{-- Left Side: Filter, Sort, Add --}}
                <div class="d-flex flex-wrap align-items-center gap-2" style="padding">

                    {{-- Filter Dropdown --}}
                    <div class="dropdown" >
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right
                        : 5px;">
                            {{ ucfirst(request('filter', 'All')) }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="{{ route('users.index', array_merge(request()->query(), ['filter' => 'all'])) }}">All</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.index', array_merge(request()->query(), ['filter' => 'active'])) }}">Active</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.index', array_merge(request()->query(), ['filter' => 'inactive'])) }}">Inactive</a></li>
                        </ul>
                    </div>

                    {{-- Sort By --}}
                    <form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center">
                        {{-- Keep previous filters/search --}}
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="sort_by" class="form-select form-select-sm me-2" onchange="this.form.submit()"  style="margin-right
                        : 5px;">
                            <option value="">Sort by</option>
                            <option value="res_fname" {{ request('sort_by') == 'res_fname' ? 'selected' : '' }}>Name</option>
                            <option value="res_email" {{ request('sort_by') == 'res_email' ? 'selected' : '' }}>Email</option>
                            <option value="res_position" {{ request('sort_by') == 'res_position' ? 'selected' : '' }}>Position</option>
                        </select>

                        <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()"  style="margin-right
                        : 5px;">
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </form>

                    
                </div>

               <div class="add-search">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Add Responder
                        </a>
                    <form method="GET" action="{{ route('users.index') }}" class="d-flex">
                        {{-- Keep previous filters/sorts --}}
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                        <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">

                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
               </div>
            </div>

            {{-- ======= TABLE ======= --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Work Position</th>
                            <th>Image</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($responders as $responder)
                        <tr>
                            <td>{{ $responder->id }}</td>
                            <td>{{ $responder->res_fname }} {{ $responder->res_lname }}</td>
                            <td>{{ $responder->res_email }}</td>
                            <td>{{ $responder->res_position }}</td>
                            <td>
                                @if($responder->res_image)
                                    <img src="{{ asset('storage/' . $responder->res_image) }}" width="50" class="rounded" alt="Profile">
                                @endif
                            </td>
                            <td class="text-center">
                                
                                <a href="{{ route('users.edit', $responder->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('users.destroy', $responder->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3 fst-italic">
                                No responders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ======= BOTTOM PAGINATOR ======= --}}
           <div class="d-flex justify-content-end mt-2">
                {{ $responders->links('vendor.pagination.custom') }}
            </div>


        </div>
    </div>
</div>
@endsection
