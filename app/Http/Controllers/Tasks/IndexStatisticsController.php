<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Services\Statistics\StatisticsService;
use Illuminate\Http\Request;

class IndexStatisticsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stats = StatisticsService::make()->getStats();

        return view('tasks.statistics')->with('stats', $stats);
    }
}
