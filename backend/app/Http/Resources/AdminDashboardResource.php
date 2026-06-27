<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'statistics' => $this['statistics'],
            'top_users' => $this['top_users'],
            'recent_submissions' => $this['recent_submissions'],
            'most_failed_scenarios' => $this['most_failed_scenarios'],
        ];
    }
}