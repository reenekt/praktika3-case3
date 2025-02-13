<?php

namespace App\Http\Controllers;

use App\Actions\Tasks\CreateTaskAction;
use App\Actions\Tasks\DeleteTaskAction;
use App\Actions\Tasks\UpdateTaskAction;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::query()->paginate(20));
    }

    /**
     * Display a listing of the resource related to current user.
     */
    public function indexMy(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::query()->where('assignee_id', auth()->id())->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, CreateTaskAction $action): TaskResource
    {
        return TaskResource::make($action->execute($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task->loadMissing(['author', 'assignee']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task, UpdateTaskAction $action): TaskResource
    {
        return TaskResource::make($action->execute($task, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, DeleteTaskAction $action): JsonResponse
    {
        $action->execute($task);

        return response()->json(null, 204);
    }
}
