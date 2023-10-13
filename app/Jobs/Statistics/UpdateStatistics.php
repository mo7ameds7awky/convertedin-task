<?php

namespace App\Jobs\Statistics;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Task $task)
    {
    }

    public function handle(): void
    {
        $assignee = $this->task->assignedTo;
        $assignee->statistic()->increment('tasks_count');
    }
}
