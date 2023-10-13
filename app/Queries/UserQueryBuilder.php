<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function byType(int $type = null)
    {
        if (! $type) {
            return $this;
        }

        return $this->where('type', $type);
    }
}
