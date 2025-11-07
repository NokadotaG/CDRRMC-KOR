@extends("Layout.main")
@section("title","Sensors")

@section("content")
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">SENSORS</h1>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body">
            {{-- ======= TOP CONTROLS ======= --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">

                {{-- Left Side: Filter, Sort, Add --}}
                <div class="d-flex flex-wrap align-items-center gap-2">

                    {{-- Filter Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right
                        : 5px;">
                            {{ ucfirst(request('filter', 'All')) }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="{{ route('sensors.index', array_merge(request()->query(), ['filter' => 'all'])) }}">All</a></li>
                            <li><a class="dropdown-item" href="{{ route('sensors.index', array_merge(request()->query(), ['filter' => 'active'])) }}">Active</a></li>
                            <li><a class="dropdown-item" href="{{ route('sensors.index', array_merge(request()->query(), ['filter' => 'inactive'])) }}">Inactive</a></li>
                        </ul>
                    </div>

                    {{-- Sort By --}}
                    <form method="GET" action="{{ route('sensors.index') }}" class="d-flex align-items-center">
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="sort_by" class="form-select form-select-sm me-2" onchange="this.form.submit()"  style="margin-right
                        : 5px;">
                            <option value="">Sort by</option>
                            <option value="sensor_name" {{ request('sort_by') == 'sensor_name' ? 'selected' : '' }}>Name</option>
                            <option value="sensor_type" {{ request('sort_by') == 'sensor_type' ? 'selected' : '' }}>Type</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        </select>

                        <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()"  style="margin-right
                        : 5px;">
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </form>
                    
                </div>

                <div class="add-search">

                    <a href="{{ route('sensors.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Sensor
                    </a>
                    
                    <form method="GET" action="{{ route('sensors.index') }}" class="d-flex align-items-center">
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                        <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">

                        <input type="text" name="search" placeholder="Search..."
                            class="form-control form-control-sm me-2"
                            style="width: 250px;"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary btn-sm">
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
                            <th>Sensor Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th class="text-center" style="width: 250px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sensors as $sensor)
                        <tr>
                            <td>{{ $sensor->id }}</td>
                            <td>{{ $sensor->sensor_name }}</td>
                            <td>{{ $sensor->sensor_type }}</td>
                            <td>
                                <span class="badge {{ $sensor->sensor_status == 'active' ? 'bg-success text-white' : 'bg-secondary text-white' }}" style="width: 120px; padding: 10px;">
                                    {{ ucfirst($sensor->sensor_status) }}
                                </span>
                            </td>
                            <td>{{ $sensor->sensor_location }}</td>
                            <td class="text-center">
                                <a href="{{ route('sensors.show', $sensor->id) }}" class="btn btn-primary btn-sm me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this sensor?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3 fst-italic">
                                No sensors found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ======= BOTTOM PAGINATOR ======= --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $sensors->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
@endsection
