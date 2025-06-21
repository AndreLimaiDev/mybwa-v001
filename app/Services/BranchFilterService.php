<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BranchFilterService
{
    public static function apply(Builder $query): Builder
    {
        $user = Auth::user();

        if ($user && $user->id !== 1) {
            return $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }
}
