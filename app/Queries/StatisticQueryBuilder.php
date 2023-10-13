<?php

namespace App\Queries;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Builder;

class StatisticQueryBuilder extends Builder
{
    public function topTen(): StatisticQueryBuilder
    {
        return $this->whereIn('user_id', fn($query) => $query->select('id')->from('users')->where('type', UserTypeEnum::USER))
            ->orderBy('tasks_count', 'desc')
            ->take(10);
    }
}
