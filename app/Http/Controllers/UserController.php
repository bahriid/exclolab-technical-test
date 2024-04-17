<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ){}

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $payload = $this->userService->loginUser($request['email'], $request['password'], $request['rememberMe']);

            return response()->json([
               'status'=> true,
               'message' => 'Login Success' ,
               'data' => $payload
            ]);
        }catch (\Throwable $exception){
            return response()->json([
               'status' => false,
               'message' => config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage()
            ], 403);
        }
    }


}
