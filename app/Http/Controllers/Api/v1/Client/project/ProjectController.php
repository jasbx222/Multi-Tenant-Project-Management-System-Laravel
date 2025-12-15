<?php

namespace App\Http\Controllers\Api\v1\Client\project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Resource\projects\ProjectResource;
use App\Service\Client\project\ProjectService;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    private $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * قائمة المشاريع للمستخدم الحالي
     */
    public function index(Request $request)
    {
        $projects = $this->projectService->getProjects();
        return ProjectResource::collection($projects);
    }


    /**
     * إنشاء مشروع جديدة
     */
    public function store(ProjectRequest $request)
    {
          $this->authorize('create', Project::class);


        return $this->projectService->store($request->validated());
        return response()->json([
            'success' => true
        ], 201);
    }

    /**
     * عرض مشروع محددة
     */

    public function show(Project  $project)
    {

        $this->authorize('view', $project);

        return new ProjectResource($this->projectService->show($project));
    }

    /**
     * تحديث مشروع
     */

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update',$project);

        return $this->projectService->updateProject($request->validated(), $project);
        return response()->json([
            'success' => true,
          
        ]);
    }

    /**
     * حذف مشروع
     */

    public function destroy(Project $project)

    {
        $this->authorize('delete', $project);

        return $this->projectService->delete($project);
    }
}
