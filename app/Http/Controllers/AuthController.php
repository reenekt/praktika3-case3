<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): UserResource|RedirectResponse
    {
        if (auth()->attempt($request->getCredentials())) {
            $request->session()->regenerate();

            if (!$request->expectsJson()) {
                return redirect()->intended();
            }

            return UserResource::make(auth()->user());
        }

        abort(401);
    }

    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        auth('web')->logout();
        auth()->guard('sanctum')->forgetUser();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if (!$request->expectsJson()) {
            return redirect()->intended();
        }

        return response()->json(['data' => null]);
    }

    public function currentUser(): UserResource
    {
        if (auth()->guest()) {
            abort(401);
        }

        return UserResource::make(auth()->user());
    }
}
