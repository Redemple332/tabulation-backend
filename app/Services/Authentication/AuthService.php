<?php

namespace App\Services\Authentication;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repository\User\UserRepositoryInterface;


class AuthService implements AuthServiceInterface {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data)
    {
        $user = $this->userRepository->getUserByEmail($data['email']);

        if (Auth::attempt($data)) {
            return [
                'token' => $user->createToken('token-name')->plainTextToken,
                'user' => $user
            ];
        } else {
            throw ValidationException::withMessages([
                'invalid_user_name_or_password' => "Invalid Email or Password"
            ]);
        }
    }
}
