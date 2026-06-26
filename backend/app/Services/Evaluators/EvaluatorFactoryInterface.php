<?php
namespace App\Services\Evaluators;
use App\Models\Scenario;
use App\Services\Evaluators\EvaluatorInterface;


interface EvaluatorFactoryInterface{

 public function getEvaluator(Scenario $scenario): EvaluatorInterface;


}