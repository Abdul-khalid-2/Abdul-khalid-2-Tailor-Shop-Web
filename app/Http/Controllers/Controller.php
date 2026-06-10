<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

abstract class Controller extends BaseController
{
    protected function isSuperAdmin(): bool
    {
        return auth()->user()?->hasRole('superadmin') ?? false;
    }

    protected function scopedBranchId(): ?int
    {
        if ($this->isSuperAdmin()) {
            return null;
        }

        return auth()->user()?->branch_id;
    }

    /** Force the authenticated user's branch on create/update for branch admins. */
    protected function enforceBranchId(array $data): array
    {
        if ($branchId = $this->scopedBranchId()) {
            $data['branch_id'] = $branchId;
        }

        return $data;
    }

    protected function authorizeSuperAdmin(): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403, 'Super Admin access required.');
        }
    }

    protected function branchScopedExists(string $table): Exists
    {
        $rule = Rule::exists($table, 'id');

        if ($branchId = $this->scopedBranchId()) {
            $rule->where('branch_id', $branchId);
        }

        return $rule;
    }

    protected function branchScopedUnique(string $table, string $column, ?int $ignoreId = null): Unique
    {
        $rule = Rule::unique($table, $column);

        if ($ignoreId) {
            $rule->ignore($ignoreId);
        }

        if ($branchId = $this->scopedBranchId()) {
            $rule->where('branch_id', $branchId);
        }

        return $rule;
    }
}
