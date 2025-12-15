<?php


namespace App\Resource\company;

use App\Resource\employee\EmployeeResource;
use App\Resource\projects\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource{
    public function toArray(Request $request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'owner'=> EmployeeResource::collection($this->users),
            'projects'=>ProjectResource::collection($this->projects)
        ];
    }
}