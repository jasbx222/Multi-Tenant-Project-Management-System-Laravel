<?php

namespace App\Service\Client\project;
use App\Models\Project;
use App\Service\Main\CrudService;


class ProjectService extends CrudService
{
    protected function getModelClass(): string
    {
        return Project::class;
    }


    public function getProjects()
    {
        return $this->getQuery()->with('users','company')->get();
    }



    /**
     * إنشاء شركة مع owner
     */
    public function store(array $data)
    {

        $project = $this->create($data);
        return $project;
    }


    public function show($project)
    {
        return $project;
    }


    public function updateProject(array $data,  $project)
    {
        return $this->update($project, $data);
    }


    public function deletePrject($project)
    {

        return $this->delete($project);
        return response()->noContent();
    }
}
