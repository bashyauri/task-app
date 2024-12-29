<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $fields = $request->only(['email', 'password']);
        $errors = Validator::make(data: $fields, rules: [
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($errors->fails()) {
            return response()->json(data: $errors->errors(), status: 422);
        }
        User::create([
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'isValidEmail' => User::IS_NOT_VALID_EMAIL,
            'remember_token' => $this->generateRandomCode(),
        ]);
        return response()->json(data: ['message' => 'User registered successfully'], status: 201);
    }
    private function generateRandomCode(): string
    {
        return bin2hex(string: random_bytes(length: 32));
    }
}