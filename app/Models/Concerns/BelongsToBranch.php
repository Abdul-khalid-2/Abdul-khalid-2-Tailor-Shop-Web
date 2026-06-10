<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToBranch
{
    public static function bootBelongsToBranch(): void
    {
        static::addGlobalScope('branch', function (Builder $builder) {
            if (app()->runningInConsole()) {
                return;
            }

            $user = auth()->user();

            if (! $user || $user->hasRole('superadmin')) {
                return;
            }

            if ($user->branch_id) {
                $builder->where($builder->qualifyColumn('branch_id'), $user->branch_id);
            }
        });

        static::creating(function (Model $model) {
            $user = auth()->user();

            if ($model->branch_id || ! $user || $user->hasRole('superadmin')) {
                return;
            }

            if ($user->branch_id) {
                $model->branch_id = $user->branch_id;
            }
        });
    }
}
