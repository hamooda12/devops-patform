<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scenario;
use App\Models\Submission;
use App\Services\ScenarioService;
use Illuminate\Http\Request;
use App\Http\Resources\SubmissionResource;
class SubmissionController extends Controller
{
    public function store(Request $request, ScenarioService $scenarioService)
{
    
    $validated = $request->validate([
  
        'scenario_id' => 'required|exists:scenarios,id',
        'command_output' => 'required|string',
       
    ]);
$scenario = Scenario::findOrFail($validated['scenario_id']);
$user = $request->user();

    $submission = Submission::create([
        'user_id' => $user->id,
        'scenario_id' => $validated['scenario_id'],
        'command_output' => $validated['command_output'],
        'score' => 0,
        'status' => 'pending',
        'type' => $scenario->type, 
    ]);

    $submission = $scenarioService->evaluateSubmission($submission);

    return response()->json([
         'message' => 'Submission evaluated successfully',
    'data' => new SubmissionResource($submission),
    ]);
}
}