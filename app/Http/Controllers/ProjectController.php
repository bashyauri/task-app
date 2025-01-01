<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\ProjectStatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function store(Request $request): JsonResponse
    {

        $fields = $request->only(['name', 'status', 'startDate', 'endDate']);
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

        return response()->json(data: ['message' => 'Project Created'], status: 201);
    }
    public function update(Request $request, $id): JsonResponse
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
        $project = Project::find(id: $id);
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
}
