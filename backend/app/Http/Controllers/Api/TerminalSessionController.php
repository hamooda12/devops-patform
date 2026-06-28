<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scenario;
use App\Models\Submission;
use App\Services\Terminal\TerminalSessionManager;
use Illuminate\Http\Request;

class TerminalSessionController extends Controller
{
    public function start(Request $request, TerminalSessionManager $terminal)
    {
        $data = $request->validate([
            'scenario_id' => 'required|exists:scenarios,id',
        ]);

        $session = $terminal->create(
            $request->user()->id,
            $data['scenario_id']
        );

        return response()->json([
            'message' => 'Terminal session started successfully',
            'data' => $session,
        ], 201);
    }

    public function execute(Request $request, TerminalSessionManager $terminal)
    {
        $data = $request->validate([
            'session_id' => 'required|string',
            'commands' => 'required|string',
        ]);

        $session = $terminal->get($data['session_id']);

        if (! $session) {
            return response()->json([
                'message' => 'Terminal session not found or expired',
            ], 404);
        }

        if ($session['user_id'] !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not allowed to use this terminal session.',
            ], 403);
        }

        $result = $terminal->execute(
            $data['session_id'],
            $data['commands']
        );

        return response()->json([
            'message' => 'Command executed successfully',
            'data' => $result,
        ]);
    }

    public function submit(Request $request, TerminalSessionManager $terminal)
    {
        $data = $request->validate([
            'session_id' => 'required|string',
        ]);

        $session = $terminal->get($data['session_id']);

        if (! $session) {
            return response()->json([
                'message' => 'Terminal session not found or expired',
            ], 404);
        }

        if ($session['user_id'] !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not allowed to submit this terminal session.',
            ], 403);
        }

        $scenario = Scenario::findOrFail($session['scenario_id']);

        $submission = Submission::create([
            'user_id' => $request->user()->id,
            'scenario_id' => $scenario->id,
            'command_output' => 'terminal_session:' . $data['session_id'],
            'score' => 0,
            'status' => 'failed',
            'feedback' => null,
        ]);

        $result = match ($scenario->slug) {
            'git-init' => app(\App\Services\Evaluators\Git\GitInitEvaluator::class)
                ->evaluateContainer($session['container_name']),

            default => [
                'score' => 0,
                'status' => 'failed',
                'feedback' => 'No evaluator found for this scenario.',
            ],
        };

        $submission->update($result);

        $terminal->destroy($data['session_id']);

        return response()->json([
            'message' => 'Terminal session submitted successfully',
            'data' => $submission->load('scenario'),
        ]);
    }

    public function stop(Request $request, TerminalSessionManager $terminal)
    {
        $data = $request->validate([
            'session_id' => 'required|string',
        ]);

        $session = $terminal->get($data['session_id']);

        if (! $session) {
            return response()->json([
                'message' => 'Terminal session not found or expired',
            ], 404);
        }

        if ($session['user_id'] !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not allowed to stop this terminal session.',
            ], 403);
        }

        $terminal->destroy($data['session_id']);

        return response()->json([
            'message' => 'Terminal session stopped successfully',
        ]);
    }
}