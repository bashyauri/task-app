<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\NewUserCreatedEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $fields = $request->only(['email', 'password']);
        $errors = Validator::make(data: $fields, rules: [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($errors->fails()) {
            if ($errors->fails()) {
                return response()->json(['errors' => $errors->errors()], 422);
            }
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
    public function validateEmail(string $token): JsonResponse|RedirectResponse
    {
        $user = User::where(column: 'remember_token', operator: $token)->update([
            'isValidEmail' => User::IS_VALID_EMAIL
        ]);

        if ($user) {
            return  redirect('/login');
        }
        return response()->json(data: ['error' => 'Invalid token'], status: 404);
    }
    public function login(Request $request): JsonResponse
    {
        $fields = $request->only(keys: ['email', 'password']);
        $errors = Validator::make(data: $fields, rules: [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($errors->fails()) {
            return response()->json(data: $errors->errors(), status: 422);
        }
        $user = User::where(column: 'email', operator: $fields['email'])->first();
        if ($user === null || !password_verify(password: $fields['password'], hash: $user->password)) {
            return response()->json(data: ['error' => 'Invalid credentials'], status: 401);
        }

        if (intval(value: $user->isValidEmail) !== User::IS_VALID_EMAIL) {
            NewUserCreatedEvent::dispatch($user);
            return response()->json(data: ['error' => 'Email is not verified'], status: 401);
        }
        $token = $user->createToken(name: 'auth_token')->plainTextToken;
        return response()->json(data: [
            'user' => $user,
            'token' => $token,
            'message' => 'User logged in successfully',
            'isLoggedIn' => true
        ], status: 200);
    }
    private function generateRandomCode(): string
    {
        return bin2hex(string: random_bytes(length: 32));
    }
}
