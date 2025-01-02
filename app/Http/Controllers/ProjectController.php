<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\ProjectStatusEnum;
use Illuminate\Support\Str;
use App\Models\TaskProgress;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = $request->query(key: 'query');
        $projects = Project::query()->with(relations: ['taskProgress']);
        if ($query !== null) {
            $projects = $projects->where(column: 'name', operator: 'like', value: "%{$query}%")
                ->orderBy(column: 'id', direction: 'desc');
            return response()->json(data: $projects->paginate(perPage: 10), status: 200);
        }

        return response()->json(data: $projects->paginate(perPage: 10), status: 200);
    }
    public function store(Request $request): JsonResponse
    {
        return DB::transaction(callback: function () use ($request) {
            $fields = $request->only(keys: ['name', 'status', 'startDate', 'endDate']);
            $errors = Validator::make(data: $fields, rules: [
                'name' => 'required|string',
                'startDate' => 'required',
                'endDate' => 'required',
            ]);

            if ($errors->fails()) {
                return response()->json(data: $errors->errors(), status: 422);
            }
            $code = Str::random(length: 10) . time();
            $project = Project::create(attributes: [
                'name' => $fields['name'],
                'status' => ProjectStatusEnum::NotStarted,
                'start_date' => $fields['startDate'],
                'end_date' => $fields['endDate'],
                'slug' => Str::slug(title: $fields['name']) . '' . $code,
            ]);
            TaskProgress::create(attributes: [
                'project_id' => $project->id,
                'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD,
                'progress' => TaskProgress::INITIAL_PROJECT_PERCENTAGE,
            ]);

            return response()->json(data: ['message' => 'Project Created'], status: 201);
        });
    }
    public function update(Request $request): JsonResponse
    {

        $fields = $request->only(keys: ['id', 'name', 'startDate', 'endDate']);
        $errors = Validator::make(data: $fields, rules: [
            'id' => 'required',
            'name' => 'required|string',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if ($errors->fails()) {
            return response()->json(data: $errors->errors(), status: 422);
        }
        $project = Project::find(id: $fields['id']);
        if (!$project) {
            return response()->json(data: ['error' => 'Project not found'], status: 404);
        }
        $code = Str::random(length: 10) . time();
        $project->update([
            'name' => $fields['name'],
            'start_date' => $fields['startDate'],
            'end_date' => $fields['endDate'],
            'slug' => Str::slug(title: $fields['name']) . ' ' . $code,
        ]);


        return response()->json(data: ['message' => 'Project Updated'], status: 200);
    }
    public function pinnedProject(Request $request)
    {
        $fields = $request->only(keys: ['project_id']);

        $errors = Validator::make(data: $fields, rules: [
            'project_id' => 'required',

        ]);

        if ($errors->fails()) {
            return response()->json(data: $errors->errors(), status: 422);
        }
        $taskProgress = TaskProgress::where('project_id', value: $fields['project_id'])->first();
        if ($taskProgress == null) {
            return response()->json(data: ['error' => 'Project not found'], status: 404);
        }


        $taskProgress->update([
            'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD,
        ]);
        return response()->json(data: ['message' => 'Project Pinned on Dashboard!'], status: 200);
    }
}