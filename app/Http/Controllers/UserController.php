<?php

namespace App\Http\Controllers;

use App\Models\Responder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        // 🔍 1. Search
        $search = $request->input('search');

        // 🔽 2. Filter
        $filter = $request->input('filter'); // Example: active, inactive, all

        // ↕️ 3. Sort
        $sortBy = $request->input('sort_by', 'id'); // default sort by id
        $sortDir = $request->input('sort_dir', 'asc'); // asc or desc

        // 🧠 Build query dynamically
        $query = Responder::query();

        // --- Apply Search ---
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('res_fname', 'like', "%{$search}%")
                  ->orWhere('res_lname', 'like', "%{$search}%")
                  ->orWhere('res_email', 'like', "%{$search}%")
                  ->orWhere('res_position', 'like', "%{$search}%");
            });
        }

        // --- Apply Filter ---
        if ($filter) {
            if ($filter === 'active') {
                $query->where('is_active', true);
            } elseif ($filter === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // --- Apply Sorting ---
        if (in_array($sortBy, ['id', 'res_fname', 'res_email', 'res_position'])) {
            $query->orderBy($sortBy, $sortDir);
        }

        // --- Apply Pagination ---
        $responders = $query->paginate(3)->appends([
            'search' => $search,
            'filter' => $filter,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        return view('users.index', compact('responders', 'search', 'filter', 'sortBy', 'sortDir'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the input fields
    $validated = $request->validate([
        'res_fname' => 'required|string|max:255',
        'res_mname' => 'required|string|max:255',
        'res_lname' => 'required|string|max:255',
        'res_suffix' => 'nullable|string|max:10',
        'res_username' => 'required|string|max:255|unique:responders,res_username',
        'res_email' => 'required|email|max:255|unique:responders,res_email',
        'res_password' => 'required|string|min:6|confirmed',
        'res_contact' => 'required|string|max:20|unique:responders,res_contact',
        'res_position' => 'required|string|max:255',
        'res_company' => 'required|string|max:255',
        'res_workadd' => 'required|string|max:500',
        'res_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Hash password
        $validated['res_password'] = Hash::make($validated['res_password']);

        // Handle image upload (if any)
        if ($request->hasFile('res_image')) {
            $validated['res_image'] = $request->file('res_image')->store('images/responders', 'public');
        }

        // Create the responder record
        Responder::create($validated);

        // Redirect back to the user list
        return redirect()
            ->route('users.index')
            ->with('success', 'New responder created successfully!');
            
    } catch (\Exception $e) {
        // Log any unexpected error
        Log::error('Responder creation failed: ' . $e->getMessage());
        return back()
            ->withErrors(['error' => 'Failed to create responder. Please try again.'])
            ->withInput();
    }
}

    
    
    public function show(string $id)
    {
        $responders = Responder::findOrFail($id);
        return view('users.show', compact('responders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $responders = Responder::findOrFail($id);
        return view('users.edit', compact('responders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $responders = Responder::findOrFail($id);
        $validationRules = [
            'res_fname' => 'required|string|max:255',
            'res_mname' => 'required|string|max:255',
            'res_lname' => 'required|string|max:255',
            'res_suffix' => 'nullable|string|max:10',
            'res_username' => ['required','string','max:255',Rule::unique('responders')->ignore($responders->id, 'id')],
            'res_email' =>  ['required','email','max:255',Rule::unique('responders')->ignore($responders->id, 'id')],
            'res_contact' =>  ['required','string','max:20',Rule::unique('responders')->ignore($responders->id, 'id')],
            'res_position' => 'required|string|max:255',
            'res_company' => 'required|string|max:255',
            'res_workadd' => 'required|string|max:255',
            'res_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if($request->filled('res_password')){
            $validationRules['res_password'] = 'min:6|confirmed';
        }
        $request->validate($validationRules);
        $data = $request->only([
            'res_fname','res_mname','res_lname','res_suffix','res_username','res_email','res_contact','res_position','res_company','res_workadd'
        ]);
        if($request->filled('res_password')){
            $data['res_password'] = Hash::make($request->res_passsword);
        }
        if($request->hasFile('res_image')){
            if($responders->res_image){
                Storage::disk('public')->delete($responders->res_image);
            }
            $data['res_image'] = $request->file('res_image')->store('images/responders', 'public');
        }
        $responders->update($data);
        return redirect()->route('users.index')->with('success', 'Responder updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $responders = Responder::findOrFail($id);
        if($responders->res_image){
            Storage::disk('public')->delete($responders->res_image);
        }
        $responders->delete();
        return redirect()->route('users.index')->with('success', 'Responder delete successfully!');
    }
}
