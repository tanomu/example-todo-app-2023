<?php

namespace App\UseCases;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;

class ArchiveTaskUseCase
{
    public function __construct(private readonly TaskRepositoryContract $taskRepository)
    {
    }

    public function handle(Task $task): Task
    {
        if (!$task->isArchived()) {
            $task->archived_at = now();
            return $this->taskRepository->save($task);

        }

        return $task;
    }
}
