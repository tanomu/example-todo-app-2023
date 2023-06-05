<?php

namespace App\UseCases;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;

class DestroyTaskUseCase
{
    public function __construct(private readonly TaskRepositoryContract $taskRepository)
    {
    }

    public function handle(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}
