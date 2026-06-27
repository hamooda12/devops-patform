<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'scenario_id' => $this->scenario_id,
            'command_output' => $this->command_output,
            'score' => $this->score,
            'status' => $this->status,
            'feedback' => $this->feedback,
            'scenario' => new ScenarioResource($this->whenLoaded('scenario')),
            'created_at' => $this->created_at,
        ];
    }
}