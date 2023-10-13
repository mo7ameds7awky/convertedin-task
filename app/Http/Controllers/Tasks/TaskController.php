<?php

namespace App\Http\Controllers\Tasks;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assignedTo', 'assignedBy'])->paginate(10);

        return view('tasks.index')->with('tasks', $tasks);
    }

    public function create()
    {
        $nonAdminUsers = User::select(['id', 'name'])->byType(UserTypeEnum::USER->value)->get();

        return view('tasks.create')->with('assignees', $nonAdminUsers);
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'assigned_to_id' => $request->get('assignee'),
            'assigned_by_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.index');
    }
}
