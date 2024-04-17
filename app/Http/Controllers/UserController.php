<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
                'message' => 'Logout Success',
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
    public function sendLink(ForgotPasswordRequest $request)
    {
        try {
            $payload = $this->userService->forgotPassword($request['email']);

            return response()->json([
                'status' => true,
                'message' => 'Reset Password link sent to your email',
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
    public function index()
    {
        try {
            $payload = $this->userService->fetchUser();

            return response()->json([
                'data' => $payload,
                'status' => true,
                'message' => 'User Fetched',
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage()
            ], 403);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function indexForgotPassword()
    {
        return view('forgot_password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(ChangePasswordRequest $request)
    {
        try {
            $payload = $this->userService->changePassword(
                $request['email'],
                $request['password'],
                $request['token'],
            );

            return redirect()->back()->with('success', 'Change Password Success');
        } catch (Throwable $exception) {
            return  redirect()->back()->with('error', config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage());
        }
    }

    public function verifyEmail(Request $request)
    {
        try {

            $payload = $this->userService->verifyEmail(
                $request['id']
            );

            return redirect()->route('verification.notice')->with('success', 'Email verified Success');
        } catch (Throwable $exception) {
            return  redirect()->back()->with('error', config('app.env') == 'production' ? 'Oops something wrong!' : $exception->getMessage());
        }
    }


}
