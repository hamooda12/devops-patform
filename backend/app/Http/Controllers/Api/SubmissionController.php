<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\ScenarioService;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    private ScenarioService $scenarioService;

    public function __construct(ScenarioService $scenarioService)
    {
        $this->scenarioService = $scenarioService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'scenario_id' => 'required|exists:scenarios,id',
            'command_output' => 'required|string',
        ]);

        $submission = Submission::create([
            'user_id' => $request->user()->id,
            'scenario_id' => $data['scenario_id'],
            'command_output' => $data['command_output'],
            'score' => 0,
            'status' => 'pending',
        ]);

        $submission = $this->scenarioService->evaluateSubmission($submission);

        return response()->json([
            'message' => 'Submission evaluated successfully',
            'data' => $submission,
        ], 201);
    }

    public function show(Request $request, Submission $submission)
    {
        if ($submission->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }

        return response()->json([
            'data' => $submission->load('scenario'),
        ]);
    }

    public function mySubmissions(Request $request)
    {
        $submissions = Submission::with('scenario')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'data' => $submissions,
        ]);
    }
}