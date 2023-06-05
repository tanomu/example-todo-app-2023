<?php

namespace App\UseCases;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;

class UnarchiveTaskUseCase
{
    public function __construct(private readonly TaskRepositoryContract $taskRepository)
    {
    }

    public function handle(Task $task): Task
    {
        if ($task->isArchived()) {
            $task->archived_at = null;
            return $this->taskRepository->save($task);

        }

        return $task;
    }
}
