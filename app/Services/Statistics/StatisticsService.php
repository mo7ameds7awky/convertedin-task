<?php

namespace App\Services\Statistics;

use App\Models\Statistic;
use Illuminate\Support\Facades\Cache;

class StatisticsService
{
    private const CACHE_MINUTES = 60;

    public function __construct()
    {
    }

    public static function make(): StatisticsService
    {
        return new self();
    }

    public function getStats()
    {
        if (Cache::has('stats')) {
            return Cache::get('stats');
        }
        $stats = $this->getTopTenUsers();
        Cache::put('stats', $stats, self::CACHE_MINUTES);

        return $stats;
    }

    private function getTopTenUsers()
    {
        return Statistic::topTen()->get();
    }
}
