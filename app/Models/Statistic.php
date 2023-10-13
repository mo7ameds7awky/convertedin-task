<?php

namespace App\Models;

use App\Queries\StatisticQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    public function newEloquentBuilder($query): StatisticQueryBuilder
    {
        return new StatisticQueryBuilder($query);
    }
}
