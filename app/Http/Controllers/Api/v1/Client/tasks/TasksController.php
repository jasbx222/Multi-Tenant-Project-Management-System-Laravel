<?php

namespace App\Http\Controllers\Api\v1\Client\tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Resource\tasks\TasksResource;
use App\Service\Client\Tasks\TaskService;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    use AuthorizesRequests;

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * قائمة المشاريع للمستخدم الحالي
     */
    public function index(Request $request)
    {

        $tasks = $this->taskService->getTasks();
        return TasksResource::collection($tasks);
    }


    /**
     * إنشاء مشروع جديدة
     */
    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);


        return $this->taskService->store($request->validated());
        return response()->json([
            'success' => true
        ], 201);
    }

    /**
     * عرض مشروع محددة
     */

    public function show(Task  $task)
    {
        $this->authorize('view', $task);


        return new TasksResource($this->taskService->show($task));
    }

    /**
     * تحديث مشروع
     */

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);


        return $this->taskService->updateTask($request->validated(), $task);
        return response()->json([
            'success' => true,
            'data'    => $task
        ]);
    }

    /**
     * حذف مشروع
     */

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        return $this->taskService->delete($task);
    }
}
