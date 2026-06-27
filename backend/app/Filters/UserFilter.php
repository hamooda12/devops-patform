<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilter
{
    public function apply(Builder $query, Request $request): Builder
    {
        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sort
        switch ($request->get('sort')) {
            case 'name':
                $query->orderBy('name');
                break;

            case 'oldest':
                $query->oldest();
                break;

            default:
                $query->latest();
        }

        return $query;
    }
}