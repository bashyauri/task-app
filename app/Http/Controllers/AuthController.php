<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\NewUserCreatedEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
            return  redirect('app/login');
        }
        return response()->json(data: ['error' => 'Invalid token'], status: 404);
    }
    public function login(Request $request): JsonResponse
    {
        // Validate request data
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        // Check if email is verified
        if ((int) $user->isValidEmail !== User::IS_VALID_EMAIL) {
            NewUserCreatedEvent::dispatch($user);

            return response()->json([
                'success' => false,
                'message' => 'Email is not verified. A verification email has been sent.',
            ], 401);
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
                'isLoggedIn' => true,
            ],
        ], 200);
    }
    private function generateRandomCode(): string
    {
        return bin2hex(string: random_bytes(length: 32));
    }
}
