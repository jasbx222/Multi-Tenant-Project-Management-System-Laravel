<?php


namespace App\Resource\projects;

use App\Resource\company\CompanyResource;
use App\Resource\employee\EmployeeResource;
use App\Resource\tasks\TasksResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'members' => EmployeeResource::collection($this->whenLoaded('users')),
            'tasks' => TasksResource::collection($this->tasks)

        ];
    }
}
