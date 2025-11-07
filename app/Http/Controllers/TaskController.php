<?php

namespace App\Http\Controllers;

use App\Models\Responder;
use App\Models\Task;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Start query with eager loading of responder (optional, for performance)
        $query = Task::with('responder');

        /** ----------------------------
         *  🔍 SEARCH FUNCTION
         *  ---------------------------- */
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhereHas('responder', function ($r) use ($search) {
                    $r->where('res_fname', 'like', "%{$search}%")
                        ->orWhere('res_lname', 'like', "%{$search}%");
                });
            });
        }

        /** ----------------------------
         *  🔖 FILTER FUNCTION
         *  ---------------------------- */
        if ($filter = $request->input('filter')) {
            if ($filter !== 'all') {
                $query->where('status', $filter);
            }
        }

        /** ----------------------------
         *  ↕️ SORT FUNCTION
         *  ---------------------------- */
        $sortBy = $request->input('sort_by', 'id'); // Default: ID
        $sortDir = $request->input('sort_dir', 'asc'); // Default: ascending

        // Only allow certain columns to be sorted to avoid SQL injection
        $allowedSorts = ['id', 'title', 'location', 'status', 'due_datetime'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        $query->orderBy($sortBy, $sortDir);

        /** ----------------------------
         *  📄 PAGINATION
         *  ---------------------------- */
        $tasks = $query->paginate(10)->withQueryString(); // Keep filters/sort/search on page change

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $responders = Responder::all();
        return view('tasks.create', compact('responders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'status' => 'required|in:pending,ongoing,completed',
            'responder_id' => 'required|exists:responders,id',
            'due_datetime' => 'required|date',
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task Created!');
    }

    public function show(string $id)
    {
        $task = Task::with('responder')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $responders = Responder::all();
        return view('tasks.edit', compact('task', 'responders'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'status' => 'required|in:pending,ongoing,completed',
            'responder_id' => 'required|exists:responders,id',
            'due_datetime' => 'required|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task Updated!');
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task Deleted!');
    }

    public function responderTasks($responderId)
    {
        $tasks = Task::with('responder')->where('responder_id', $responderId)->get();
        return response()->json($tasks);
    }

    public function updateStatus(Request $request, $taskId)
    {
        $request->validate(['status' => 'required|in:pending,ongoing,completed']);
        $task = Task::findOrFail($taskId);
        $task->update(['status' => $request->status]);
        return response()->json(['message' => 'Status updated']);
    }

    public function submitFeedback(Request $request, $taskId)
    {
        $request->validate([
            'comments' => 'required|string',  // Adjust validation based on your fields
            'rating' => 'nullable|integer|min:1|max:5',  // Example for rating
        ]);
        // Assuming the responder is authenticated via Sanctum
        $responder = Auth::user();  // Or Auth::guard('responder')->user() if custom guard
        // Create feedback in the 'feedbacks' table
        $feedback = Feedback::create([
            'task_id' => $taskId,
            'responder_id' => $responder->id,
            'comments' => $request->comments,
            'rating' => $request->rating,  // Add other fields as needed
        ]);
        return response()->json([
            'message' => 'Feedback submitted successfully.',
            'feedback' => $feedback,
        ]);
    }
}