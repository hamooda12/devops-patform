<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'completed_scenarios' => $this['completed_scenarios'],
            'passed_submissions' => $this['passed_submissions'],
            'total_attempted_scenarios' => $this['total_attempted_scenarios'],
            'total_submissions' => $this['total_submissions'],
            'scenarios' => $this['scenarios'],
            'failed_submissions' => $this['failed_submissions'],
            'total_points' => $this['total_points'],
            'success_rate' => $this['success_rate'],
            'overall_progress_rate' => $this['overall_progress_rate'],
        ];
    }
}