<?php

namespace App\Services;

use App\Models\Submission;

use App\Services\Evaluators\EvaluatorFactoryInterface;

class ScenarioService
{
    private EvaluatorFactoryInterface $factory;
    public function __construct(EvaluatorFactoryInterface $factory)
{
    $this->factory = $factory;
}
    public function evaluateSubmission(Submission $submission): Submission
    {
        $scenario = $submission->scenario;

        $evaluator =$this->factory->getEvaluator($scenario);

        $result = $evaluator->evaluate($scenario, $submission);

        $submission->score = $result['score'];
        $submission->status = $result['status'];
        $submission->feedback = $result['feedback'];
        $submission->save();

        return $submission->fresh('scenario');
    }
}