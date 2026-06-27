<?php

namespace App\Http\Controllers\Api;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scenario;
use App\Http\Resources\ScenarioResource;

class ScenarioController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return  ScenarioResource::collection(Scenario::all());
    }

    public function show(Scenario $scenario)
    {
        return new ScenarioResource($scenario);
    }
  
public function store(Request $request)
{
    $this->authorize('create', Scenario::class);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:scenarios,slug',
        'description' => 'required|string',
        'type' => 'required|string',
        'difficulty' => 'required|string',
        'points' => 'required|integer|min:1',
    ]);

    $scenario = Scenario::create($data);

    return response()->json([
        'message' => 'Scenario created successfully',
        'data' =>  new ScenarioResource($scenario),
    ], 201);
}

public function update(Request $request, Scenario $scenario)
{
    $this->authorize('update', $scenario);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:scenarios,slug,' . $scenario->id,
        'description' => 'required|string',
        'type' => 'required|string',
        'difficulty' => 'required|string',
        'points' => 'required|integer|min:1',
    ]);

    $scenario->update($data);

    return response()->json([
        'message' => 'Scenario updated successfully',
        'data' =>  new ScenarioResource($scenario),
    ]);
}

public function destroy(Scenario $scenario)
{
    $this->authorize('delete', $scenario);

    $scenario->delete();

    return response()->json([
        'message' => 'Scenario deleted successfully',
    ]);
}
}