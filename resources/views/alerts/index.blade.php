@extends("Layout.main")
@section("title","Alerts")

@section("content")
<div class="container mt-4">
    <div class="header">
        <h1 class="fw-bold">ALERTS</h1>
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
                            <li><a class="dropdown-item" href="{{ route('alerts.index', array_merge(request()->query(), ['filter' => 'all'])) }}">All</a></li>
                            <li><a class="dropdown-item" href="{{ route('alerts.index', array_merge(request()->query(), ['filter' => 'low'])) }}">Low</a></li>
                            <li><a class="dropdown-item" href="{{ route('alerts.index', array_merge(request()->query(), ['filter' => 'moderate'])) }}">Moderate</a></li>
                            <li><a class="dropdown-item" href="{{ route('alerts.index', array_merge(request()->query(), ['filter' => 'high'])) }}">High</a></li>
                        </ul>
                    </div>

                    {{-- Sort By --}}
                    <form method="GET" action="{{ route('alerts.index') }}" class="d-flex align-items-center">
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="sort_by" class="form-select form-select-sm me-2" onchange="this.form.submit()" style="margin-right
                        : 5px;">
                            <option value="">Sort by</option>
                            <option value="location" {{ request('sort_by') == 'location' ? 'selected' : '' }}>Location</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date</option>
                        </select>

                        <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()" style="margin-right
                        : 5px;">
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </form>
                </div>
                <div class="add-search">
                    <a href="{{ route('alerts.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Alert
                    </a>
                    <form method="GET" action="{{ route('alerts.index') }}" class="d-flex align-items-center">
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

            {{-- ======= SUCCESS ALERT (SweetAlert) ======= --}}
            @if(session('success'))
                <script>
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

           {{-- ======= ALERTS LIST ======= --}}
            <ul class="list-group list-group-flush">
                @forelse ($alerts as $alert)
                    @php
                        $badgeClass = match(strtolower($alert->status)) {
                            'low' => 'bg-success text-white',
                            'moderate' => 'bg-warning text-dark',
                            'high' => 'bg-danger text-white',
                            default => 'bg-secondary'
                        };
                    @endphp

                    <li class="list-group-item d-flex justify-content-between align-items-start mb-2" 
                        style="box-shadow: 0 0 3px #000; border-radius: 10px; width:100%;">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $alert->location }}</h6>
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($alert->status) }}</span>
                            <div class="small text-muted mt-1">
                                <strong>Notes:</strong> {{ $alert->notes ?? '—' }}
                            </div>
                        </div>
                        <div class="text-end ms-3">
                            <div class="small text-muted mb-2">
                                <strong>Triggered By:</strong> {{ $alert->triggered_by ?? 'Monitoring Device' }}
                            </div>
                            <div class="text-center" style="min-width: 180px;">
                               <a href="{{ route('alerts.show', $alert->id) }}" class="btn btn-primary btn-sm me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('alerts.edit', $alert->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('alerts.destroy', $alert->id) }}" method="POST" class="d-inline" >
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this alert?')" style="margin-top: -10px;">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted fst-italic py-3">
                        No alerts found.
                    </li>
                @endforelse
            </ul>

            {{-- ======= PAGINATION ======= --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $alerts->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>
    <script src="public/js/script.js"></script>
</div>
@endsection
