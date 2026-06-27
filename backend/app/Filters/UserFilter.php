<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilter
{
    public function apply(Builder $query, Request $request): Builder
    {
        $this->search($query, $request);
        $this->role($query, $request);
        $this->sort($query, $request);

        return $query;
    }

    private function search(Builder $query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    }

    private function role(Builder $query, Request $request): void
    {
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
    }

    private function sort(Builder $query, Request $request): void
    {
        match ($request->get('sort')) {
            'name' => $query->orderBy('name'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };
    }
}