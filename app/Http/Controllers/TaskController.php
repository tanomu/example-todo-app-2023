<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\UseCases\ArchiveTaskUseCase;
use App\UseCases\CreateTaskUseCase;
use App\UseCases\UnarchiveTaskUseCase;
use App\UseCases\UpdateTaskUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(private readonly TaskRepositoryContract $taskRepository)
    {
    }

    // 一覧を返す
    public function index(): ResourceCollection
    {
        return TaskResource::collection(Task::query()->whereNull('archived_at')->orderByDesc('id')->get());
    }

    // 新規作成する
    public function create(CreateTaskUseCase $useCase, Request $request): Response
    {
        $useCase->handle(data: $request->all());
        return response()->noContent(201);
    }

    // 更新する
    public function update(UpdateTaskUseCase $useCase, Request $request, int $id): Response
    {
        $useCase->handle(
            task: $this->fetchTask(id: $id),
            data: $request->all()
        );
        return response()->noContent(200);
    }

    // アーカイブする
    public function archive(ArchiveTaskUseCase $useCase, int $id): Response
    {
        $useCase->handle(task: $this->fetchTask(id: $id));
        return response()->noContent(200);
    }

    // アーカイブを解除する
    public function unarchive(UnarchiveTaskUseCase $useCase, int $id): Response
    {
        $useCase->handle(task: $this->fetchTask(id: $id));
        return response()->noContent(200);
    }

    private function fetchTask(int $id): Task
    {
        $task = $this->taskRepository->find(id: $id);
        if (!$task) {
            abort(404);
        }
        return $task;
    }
}
