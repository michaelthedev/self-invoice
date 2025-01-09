<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ProjectController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->response(
            message: "Projects",
            data: Project::with(['client', 'invoices'])
                ->latest()->paginate()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
            'client_id' => ['required', 'exists:clients,id'],
        ]);

        $project = Project::create($validated);

        return $this->response(
            status: 201,
            message: "Project created",
            data: $project
        );
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
            'client_id' => ['sometimes', 'exists:clients,id'],
        ]);

        $project->update($validated);

        return $this->response(
            message: "Project updated",
            data: $project
        );
    }

    public function show(Project $project): JsonResponse
    {
        $project->load(['client', 'invoices']);

        return $this->response(
            message: "Project",
            data: $project
        );
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return $this->response(
            message: "Project deleted"
        );
    }
}
