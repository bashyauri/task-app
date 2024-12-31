<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\NewUserCreatedEvent;
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
        $user = User::create([
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'isValidEmail' => User::IS_NOT_VALID_EMAIL,
            'remember_token' => $this->generateRandomCode(),
        ]);
        NewUserCreatedEvent::dispatch($user);
        return response()->json(data: ['message' => 'User registered successfully', 'user' => $user], status: 201);
    }
    public function validateEmail(string $token)
    {
        $user = User::where('remember_token', $token)->update([
            'isValidEmail' => User::IS_VALID_EMAIL
        ]);

        if ($user) {
            return  redirect('/login');
        }
        return response()->json(data: ['message' => 'Invalid token'], status: 404);
    }
    private function generateRandomCode(): string
    {
        return bin2hex(string: random_bytes(length: 32));
    }
}