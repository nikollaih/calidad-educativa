<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilters {
    public function scopeFilters(Builder $query, ?callable $filters = null) {
        if (is_callable($filters)) {
            return $filters($query);
        }

        return $query;
    }
}

