<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $query = Sensor::query();

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('sensor_name', 'like', "%{$search}%")
                ->orWhere('sensor_type', 'like', "%{$search}%")
                ->orWhere('sensor_location', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($type = $request->input('type')) {
            $query->where('sensor_type', $type);
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('sensor_status', $status);
        }

        // Sorting
        $sort = $request->input('sort', 'id'); // default sort column
        $direction = $request->input('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Pagination
        $sensors = $query->paginate(8)->appends($request->all());

        return view('sensors.index', compact('sensors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sensors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sensor_name' => 'required',
            'sensor_type' => 'required',
            'sensor_location' => 'required',
            'sensor_status' => 'required',
        ]);

        $sensors = Sensor::create([
            "sensor_name" => $request['sensor_name'],
            "sensor_type" => $request['sensor_type'],
            "sensor_location" => $request['sensor_location'],
            "sensor_status" => $request['sensor_status'],
        ]);

         if($sensors -> save()){
         return redirect(route("sensors.index"))->with("success","New responder created successfully!");
      }
      return redirect(route("sensors.create"))->with("error","Failed to create");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $sensors = Sensor::findOrFail($id);
        return view("sensors.show", compact('sensors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sensors = Sensor::findOrFail($id);
        return view("sensors.edit", compact('sensors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $sensors = Sensor::findOrFail($id);
        $sensors->delete();

        return redirect()->route('sensors.index')->with('success','Sensor Remove Successfully!');
    }
}
