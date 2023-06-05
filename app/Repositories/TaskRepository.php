<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;

class TaskRepository implements TaskRepositoryContract
{
    public function find(int $id): ?Task
    {
        return Task::find($id);
    }

    public function save(Task $task): Task {
        $task->save();
        return $task;
    }
}
