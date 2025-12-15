<?php

namespace App\Service\Client\Tasks;
use App\Models\Task;
use App\Service\Main\CrudService;


class TaskService extends CrudService
{
    protected function getModelClass(): string
    {
        return Task::class;
    }


    public function getTasks()
    {
        return $this->getQuery()->with('project')->get();
    }



    /**
     * إنشاء شركة مع owner
     */
    public function store(array $data)
    {

        $task = $this->create($data);
        return $task;
    }


    public function show($task)
    {
        return $task;
    }


    public function updateTask(array $data,  $task)
    {
        return $this->update($task, $data);
    }


    public function deleteTask($task)
    {

        return $this->delete($task);
        return response()->noContent();
    }
}
