<?php

namespace App\Services\Evaluators;

use App\Models\Scenario;
use App\Models\Submission;

interface EvaluatorInterface
{
    public function evaluate(Scenario $scenario, Submission $submission): array;
}