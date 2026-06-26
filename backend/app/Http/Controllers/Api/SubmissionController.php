<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scenario;
use App\Models\Submission;
use App\Services\ScenarioService;
use Illuminate\Http\Request;
class SubmissionController extends Controller
{
    public function store(Request $request, ScenarioService $scenarioService)
{
    $validated = $request->validate([
        'user_id' => 'required|integer',
        'scenario_id' => 'required|exists:scenarios,id',
        'command_output' => 'required|string',
       
    ]);
$scenario = Scenario::findOrFail($validated['scenario_id']);
    $submission = Submission::create([
        'user_id' => $validated['user_id'],
        'scenario_id' => $validated['scenario_id'],
        'command_output' => $validated['command_output'],
        'score' => 0,
        'status' => 'pending',
        'type' => $scenario->type, 
    ]);

    $submission = $scenarioService->evaluateSubmission($submission);

    return response()->json([
        'message' => 'Submission evaluated successfully',
        'feedback' => $submission->feedback,
        'data' => $submission,
    ]);
}
}