<?php

namespace App\Http\Controllers;

use App\Models\MapPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvacuationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()  // For fetching points, if needed
    {
       $locations = MapPoint::all();
       return view('evacuation.index', compact('locations'));
        
    }
    public function getPoints()
    {
        return MapPoint::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Store method called', $request->all());
        
        try {
            $validated = $request->validate([
                'type' => 'required|in:evacuation,flood',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'address' => 'nullable|string',
            ]);

            \Log::info('Validation passed', $validated);

            $mapPoint = MapPoint::create($validated);
            
            \Log::info('Location created successfully', $mapPoint->toArray());

            return redirect()->route('evacuation.index')
                ->with('success', 'Location saved successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error saving evacuation point: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to save location: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try {
            $mapPoint = MapPoint::findOrFail($id);
            $mapPoint->delete();

            return redirect()->route('evacuation.index')
                ->with('success', 'Location deleted successfully');

        } catch (\Exception $e) {
            Log::error('Error deleting evacuation point: ' . $e->getMessage());
            return redirect()->route('evacuation.index')
                ->with('error', 'Failed to delete location');
        }
    }
}
