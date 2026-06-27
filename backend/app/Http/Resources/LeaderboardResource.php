<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this['user_id'],
            'name' => $this['name'],
            'total_points' => $this['total_points'],
            'completed_scenarios' => $this['completed_scenarios'],
        ];
    }
}