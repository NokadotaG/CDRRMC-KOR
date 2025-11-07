@extends("Layout.main")
@section("title","Tasks")

@section("content")
<div class="container mt-4">
    <div class="header mb-3">
        <h1 class="fw-bold">TASK MANAGER</h1>
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
                            <li><a class="dropdown-item" href="{{ route('tasks.index', array_merge(request()->query(), ['filter' => 'all'])) }}">All</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', array_merge(request()->query(), ['filter' => 'pending'])) }}">Pending</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', array_merge(request()->query(), ['filter' => 'ongoing'])) }}">Ongoing</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', array_merge(request()->query(), ['filter' => 'completed'])) }}">Completed</a></li>
                        </ul>
                    </div>

                    {{-- Sort By --}}
                    <form method="GET" action="{{ route('tasks.index') }}" class="d-flex align-items-center">
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="sort_by" class="form-select form-select-sm me-2" onchange="this.form.submit()" style="margin-right
                        : 5px;">
                            <option value="">Sort by</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="location" {{ request('sort_by') == 'location' ? 'selected' : '' }}>Location</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                            <option value="due_datetime" {{ request('sort_by') == 'due_datetime' ? 'selected' : '' }}>Due Date</option>
                        </select>

                        <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()" style="margin-right
                        : 5px;">
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </form>
                    
                </div>
            <div class="add-search">
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Task
                    </a>
                
                <form method="GET" action="{{ route('tasks.index') }}" class="d-flex align-items-center">
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

            {{-- ======= TOP PAGINATOR ======= --}}
            <div class="d-flex justify-content-end mb-2">
                {{ $tasks->links('vendor.pagination.custom') }}
            </div>

            {{-- ======= TABLE ======= --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Responder</th>
                            <th>Status</th>
                            <th>Due Date & Time</th>
                            <th class="text-center" style="width: 250px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->location }}</td>
                            <td>{{ $task->responder?->res_fname }} {{ $task->responder?->res_lname }}</td>
                            <td>
                                <span class="badge 
                                    @if($task->status === 'pending') bg-warning text-dark
                                    @elseif($task->status === 'ongoing') bg-info text-white
                                    @elseif($task->status === 'completed') bg-success text-white
                                    @else bg-secondary 
                                    @endif" style="width:80px; padding:10px">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ $task->due_datetime ? \Carbon\Carbon::parse($task->due_datetime)->format('Y-m-d h:i A') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this task?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3 fst-italic">
                                No tasks found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ======= BOTTOM PAGINATOR ======= --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $tasks->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
@endsection
