<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
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

        return response()->json([
            'message' => 'Submission created successfully',
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
            'data' => $submission,
        ]);
    }
}