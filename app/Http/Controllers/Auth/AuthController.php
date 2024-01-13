<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Services\Authentication\AuthService;
use App\Services\Utils\ResponseServiceInterface;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $authService;
    private $responseService;

    public function __construct(AuthService $authService, ResponseServiceInterface $responseService)
    {
        $this->authService = $authService;
        $this->responseService = $responseService;
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());

        $cookie = cookie('token', $data['token'], 3600);

        return $this->responseService->authResponse("Login Successful", $data, $cookie);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete(); // current token
        // $user->tokens()->delete(); // all tokens

        return $this->responseService->resolveResponse("Logout Successful", null);
    }

    public function authUser()
    {
        $user = new UserResource(Auth::user());
        return $this->responseService->resolveResponse('Auth User', $user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());
        return $this->responseService->updateResponse('Profile', $user);
    }

    /* Password Resets Functions */
    public function setPasswordResetToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);


        $status = Password::sendResetLink($request->only('email'));


        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status)
            ], 201);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password reset successfully.'
            ], 201);
        }

        return response([
            'message' => __($status)
        ], 500);
    }
}
