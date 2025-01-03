<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function createTask(Request $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $fields = $request->only(keys: ['projectId', 'name', 'memberIds']);
            $errors = Validator::make(data: $fields, rules: [
                'name' => 'required|string',
                'projectId' => 'required|integer',
                'memberIds' => 'required|array',
                'memberIds.*' => 'required|integer',
            ]);

            if ($errors->fails()) {
                return response()->json(data: $errors->errors(), status: 422);
            }

            $task = Task::create(attributes: [
                'name' => $fields['name'],
                'project_id' => $fields['projectId'],
                'status' => Task::NOT_STARTED,
            ]);
            $members = collect($fields['memberIds'])->map(function ($memberId) use ($task) {
                TaskMember::create(attributes: [
                    'project_id' => $task->project_id,
                    'task_id' => $task->id,
                    'member_id' => $memberId,
                ]);
            });

            return response()->json(data: ['message' => 'Tasks Created'], status: 201);
        });
    }
}
