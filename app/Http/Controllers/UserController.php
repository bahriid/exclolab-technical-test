<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $payload = $this->userService->loginUser($request['email'], $request['password'], $request['rememberMe']);

            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'data' => $payload
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage()
            ], 403);
        }
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $payload = $this->userService->registerUser(
                $request['name'],
                $request['email'],
                $request['password']
            );

            return response()->json([
                'status' => true,
                'message' => 'Register Success',
                'data' => $payload
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage()
            ], 403);
        }
    }


    /**
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            $payload = $this->userService->logoutUser();

            return response()->json([
                'status' => true,
                'message' => 'Register Success',
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage()
            ], 403);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            $payload = $this->userService->logoutUser();

            return response()->json([
                'status' => true,
                'message' => 'Register Success',
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage()
            ], 403);
        }
    }


}
