<?php

namespace App\Contracts\Repositories;

use App\Models\Task;

interface TaskRepositoryContract
{
    public function find(int $id): ?Task;
    public function save(Task $task): Task;
    public function delete(Task $task): void;
}
