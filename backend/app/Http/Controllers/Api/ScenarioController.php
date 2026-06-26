<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scenario;
use App\Http\Resources\ScenarioResource;
class ScenarioController extends Controller
{
    public function index()
    {
        return  ScenarioResource::collection(Scenario::all());
    }

    public function show(Scenario $scenario)
    {
        return new ScenarioResource($scenario);
    }
}