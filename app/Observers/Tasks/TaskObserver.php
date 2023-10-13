<?php

namespace App\Observers\Tasks;

use App\Jobs\Statistics\UpdateStatistics;
use App\Models\Task;

class TaskObserver
{
    public function created(Task $task): void
    {
        UpdateStatistics::dispatch($task);
    }
}
