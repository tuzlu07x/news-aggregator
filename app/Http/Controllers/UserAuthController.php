<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AuthLoginRequest;
use App\Http\Requests\User\AuthRegisterRequest;
use App\Http\Resources\User\AuthLoginResource;
use App\Http\Resources\User\AuthRegisterResource;
use App\Services\User\AuthServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{

    public function __construct(private readonly AuthServiceImpl $authService) {}
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authService->createUser($data);

        return AuthRegisterResource::make($user)->response()->setStatusCode(201);
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authService->getUserByEmail($data);

        if (!$user || !Hash::check($data['password'], $user->password)) return response()
            ->json(['message' => 'Invalid Credentials'], 401);

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return AuthLoginResource::make(['id' => $user->id, 'name' => $user->name, 'access_token' => $token])
            ->response()->setStatusCode(200);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->authService->deleteUserToken($user);
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
