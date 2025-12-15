<?php

namespace App\Resource\tasks;

use App\Resource\projects\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{


    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'priority' => $this->priority,
            'status' => $this->status,
            'end_task' => $this->end_task
        ];
    }
}
