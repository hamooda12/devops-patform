<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scenario;

class ScenarioController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Scenario::latest()->get()
        ]);
    }

    public function show(Scenario $scenario)
    {
        return response()->json([
            'data' => $scenario
        ]);
    }
}