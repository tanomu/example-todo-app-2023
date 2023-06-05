<?php

namespace App\UseCases;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;
use App\Rules\SingleLineString;
use Illuminate\Support\Facades\Validator;

class CreateTaskUseCase
{
    public function __construct(private readonly TaskRepositoryContract $taskRepository)
    {
    }

    public function handle(array $data): Task
    {
        $data = Validator::validate($data, [
            'title' => ['required', 'string', new SingleLineString(), 'max:100'],
            'body' => ['required', 'string', 'max:10000'],
        ]);

        $task = new Task();
        $task->title = $data['title'];
        $task->body = $data['body'];
        $task->archived_at = null;

        return $this->taskRepository->save($task);
    }
}
