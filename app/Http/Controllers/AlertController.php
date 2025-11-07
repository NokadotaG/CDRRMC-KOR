<?php

namespace App\Http\Controllers;

use App\Events\AlertCreated;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start query builder
        $query = Alert::query();

        // 🔍 SEARCH FILTER
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhere('triggered_by', 'like', "%{$search}%");
            });
        }

        // ⚙️ FILTER BY STATUS
        $filter = strtolower($request->input('filter', 'all'));
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        // ↕️ SORTING
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        if (!in_array($sortBy, ['location', 'status', 'created_at'])) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir);

        // 📄 PAGINATION (10 per page)
        $alerts = $query->paginate(5)->appends($request->query());

        // Return view
        return view('alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alerts = Alert::latest()->get();
        return view('alerts.create', compact('alerts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request-> validate([
            'location' => 'required',
            'status' => 'required|string|in:Low,Moderate,High',
            'triggered_by' => 'required|string|in:Admin,Monitoring Device',
            'notes' => 'nullable|string',
        ]);

        $alert = Alert::create($request->all());
        if($alert->status === 'High'){
            event(new AlertCreated($alert));
        }
        return redirect()->route('alerts.index')->with('success', 'Alert Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alert $alert)
    {
        return view('alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alert $alert)
    {
        return view('alerts.edit', compact('alert'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        $request-> validate([
            'location' => 'required',
            'status' => 'required|string|in:Low,Moderate,High',
            'triggered_by' => 'required|string|in:Admin,Monitoring Device',
            'notes' => 'nullable|string',
        ]);

        $alert->update($request->all());

        return redirect()->route('alerts.index')->with('success','Alert Udpated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();
        return redirect()->route('alerts.index')->with('success', 'Alert has been deleted');
    }
}
