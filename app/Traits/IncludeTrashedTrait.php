<?php

namespace App\Traits;

trait IncludeTrashedTrait
{
    /**
     * {@inheritdoc}
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($field ?? $this->getRouteKeyName(), $value)->first();
    }
}
