<?php

namespace App\Repositories\User;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function __construct(
        protected UserRepository $userRepository
    )
    {
        //
    }

    /**
     * @param $email
     * @param $password
     * @return array|Builder|Builder[]|Collection|Model
     * @throws Exception
     */
    public function loginUser($email, $password, $rememberMe = false): Model|Collection|Builder|array
    {
        $user = $this->userRepository->findBy(['email' => $email]);

        if (!$user) {
            throw new Exception('User not found');
        }

        if (!Hash::check($password, $user['password'])) {
            throw new Exception('Password is wrong');
        }

        if (!$user->email_verified_at) {
            //TODO:: Send Email Verify

            throw new Exception('We have sent you email verification, please verify your email');
        }

        $expiration = $rememberMe ? config('sanctum.month_expiration') : config('sanctum.expiration');
        $expirationDate = now()->addDays($expiration / 24);

        // Revoke all tokens
        $user->tokens()->delete();

        // Create new Token
        $token = $user->createToken(
            name: $user->email . '-Auth',
            expiresAt: $expirationDate
        )->plainTextToken;

        return [
            'access_token' => $token,
            'user' => $user,
        ];
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     * @return Model|Collection|Builder|array
     */
    public function registerUser($name, $email, $password): Model|Collection|Builder|array
    {
        $user = $this->userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return [
            'user' => $user,
        ];
    }

    public function logoutUser()
    {
        auth()->user()->tokens()->delete();

        return true;
    }
}
