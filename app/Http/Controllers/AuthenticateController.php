<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        /** @var User $user */
        $user = User::create($validated);

        return response()->json([
            'message' => 'User registered',
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            /** @var User $user */
            $user = Auth::user();

            $token = $user->createToken('Personal Token')->accessToken;
            return response()->json([
                'token_type' => 'Bearer',
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'error' => 'invalid_credentials',
                'message' => 'Invalid user credentials!'
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
