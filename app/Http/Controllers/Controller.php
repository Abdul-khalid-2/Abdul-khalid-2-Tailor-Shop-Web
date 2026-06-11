<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

abstract class Controller extends BaseController
{
    /**
     * Store an uploaded image inside public/assets/branch_{id}/{folder}/, creating
     * the directory if needed, and return the web-relative path to save in the DB.
     *
     * Examples:
     *   public/assets/branch_1/customer_imgs/customer_imgs_20260611_ab12cd34.jpg
     *   public/assets/branch_2/tailor_images/tailor_images_20260611_ef56gh78.png
     */
    protected function storeBranchImage(UploadedFile $file, string $folder, ?int $branchId, ?string $oldPath = null): string
    {
        $branchId = $branchId ?: 0;
        $relativeDir = "assets/branch_{$branchId}/{$folder}";
        $absoluteDir = public_path($relativeDir);

        if (! is_dir($absoluteDir)) {
            mkdir($absoluteDir, 0755, true);
        }

        // Remove the previous image (if replacing) so old files don't pile up.
        if ($oldPath) {
            $this->deleteBranchImage($oldPath);
        }

        $extension = $file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg';
        $filename = $folder.'_'.now()->format('Ymd_His').'_'.Str::random(8).'.'.$extension;

        $file->move($absoluteDir, $filename);

        return $relativeDir.'/'.$filename;
    }

    /** Delete a previously stored public image by its web-relative path. */
    protected function deleteBranchImage(?string $path): void
    {
        if ($path && is_file(public_path($path))) {
            @unlink(public_path($path));
        }
    }

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
