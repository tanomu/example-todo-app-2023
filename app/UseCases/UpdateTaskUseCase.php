<?php
namespace App\UseCases;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;
use App\Rules\SingleLineString;
use Illuminate\Support\Facades\Validator;

class UpdateTaskUseCase {
    public function __construct(private readonly TaskRepositoryContract $taskRepository)
    {
    }

    public function handle(Task $task, array $data): Task {
        $data = Validator::validate($data, [
            'title' => ['required', 'string', new SingleLineString(), 'max:100'],
            'body' => ['required', 'string', 'max:10000'],
        ]);

        $task->title = $data['title'];
        $task->body = $data['body'];
        return $this->taskRepository->save($task);
    }
}
