<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index(Request $request): JsonResponse
    {

        $query = $request->query(key: 'query');
        $members = Member::select(['name', 'email']);
        if ($query !== null) {
            $members = $members->where('name', 'like', "%{$query}%")
                ->orderBy(column: 'id', direction: 'desc');
            return response()->json(data: $members->paginate(perPage: 10), status: 200);
        }

        return response()->json(data: $members->paginate(perPage: 10), status: 200);
    }
    public function store(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'data' => $member,
            'message' => 'Member created successfully'
        ], 201);
    }
    public function update(Request $request): JsonResponse
    {

        $fields = $request->only(keys: ['id', 'name', 'email']);
        $errors = Validator::make(data: $fields, rules: [
            'id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',

        ]);

        if ($errors->fails()) {
            return response()->json(data: $errors->errors(), status: 422);
        }
        $member = Member::find(id: $fields['id']);
        if (!$member) {
            return response()->json(data: ['error' => 'Member not found'], status: 404);
        }

        $member->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
        ]);


        return response()->json(data: ['message' => 'Member Updated'], status: 200);
    }
}
